<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Form extends Component
{
    use AuthorizesRequests;

    public ?User $user = null;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    // Selecciones del formulario
    public array $roles = [];        // nombres de rol
    public array $permissions = [];  // permisos directos (checkbox editables)

    // Derivados (para la vista)
    public array $inheritedPerms = []; // permisos heredados por roles (solo lectura)

    #[Url] public ?string $redirect = null;

    public function mount(?User $user = null): void
    {
        $this->user = $user;

        if ($this->user && $this->user->exists) {
            $this->authorize('update', $this->user);

            $this->fill([
                'name'        => $this->user->name,
                'email'       => $this->user->email,
                'roles'       => $this->user->roles()->pluck('name')->toArray(),
                // Directos únicamente (no incluye heredados por rol)
                'permissions' => $this->user->getDirectPermissions()->pluck('name')->toArray(),
            ]);
        } else {
            $this->authorize('create', User::class);
            $this->user = null;
        }

        $this->recomputeInheritedPerms();
        // Nota: NO mezclamos heredados dentro de "permissions" (directos).
    }

    protected function rules(): array
    {
        $emailRule = Rule::unique('users','email')->ignore($this->user?->id);

        $base = [
            'name'         => ['required','string','max:190'],
            'email'        => ['required','email','max:190', $emailRule],
            'roles'        => ['array'],
            'roles.*'      => ['string','exists:roles,name'],
            'permissions'  => ['array'],
            'permissions.*'=> ['string','exists:permissions,name'],
        ];

        if ($this->user && $this->user->exists) {
            $base['password'] = ['nullable','string','min:8','confirmed'];
        } else {
            $base['password'] = ['required','string','min:8','confirmed'];
        }

        return $base;
    }

    protected $messages = [
        'name.required'      => 'Ingresa un nombre.',
        'email.required'     => 'Ingresa un email.',
        'email.email'        => 'Email inválido.',
        'email.unique'       => 'Este email ya está registrado.',
        'password.required'  => 'Ingresa una contraseña.',
        'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
        'password.confirmed' => 'Las contraseñas no coinciden.',
    ];

    /**
     * Livewire hook: al cambiar roles, recalculamos heredados
     * y quitamos de "directos" los que ahora sean heredados (no duplicar).
     */
    public function updatedRoles(): void
    {
        $this->recomputeInheritedPerms();

        // Quitar de permisos directos los que ya vengan heredados por rol:
        $this->permissions = array_values(array_diff($this->permissions, $this->inheritedPerms));
    }

    private function recomputeInheritedPerms(): void
    {
        $guard = config('auth.defaults.guard', 'web');

        if (empty($this->roles)) {
            $this->inheritedPerms = [];
            return;
        }

        $rolePerms = Role::query()
            ->whereIn('name', $this->roles)
            ->where('guard_name', $guard)
            ->with(['permissions' => function ($q) use ($guard) {
                $q->where('guard_name', $guard)->select('permissions.id','permissions.name','permissions.guard_name');
            }])
            ->get()
            ->flatMap(fn($r) => $r->permissions->pluck('name'))
            ->unique()
            ->values()
            ->toArray();

        $this->inheritedPerms = $rolePerms;
    }

    public function save(): void
    {
        $data = $this->validate();

        // 1) Sincroniza roles.
        // 2) Asigna directos = seleccionados MENOS los heredados por rol.
        $directToAssign = array_values(array_diff($data['permissions'] ?? [], $this->inheritedPerms));

        if ($this->user && $this->user->exists) {
            $this->user->name  = $data['name'];
            $this->user->email = $data['email'];

            if (!empty($data['password'])) {
                $this->user->password = Hash::make($data['password']);
            }

            // Si por alguna razón no está verificado, lo marcamos ahora
            if (is_null($this->user->email_verified_at)) {
                $this->user->email_verified_at = now();
            }

            $this->user->save();

            $this->user->syncRoles($data['roles'] ?? []);
            $this->user->syncPermissions($directToAssign);

            session()->flash('ok', 'Usuario actualizado.');
        } else {
            $u = new User();
            $u->name  = $data['name'];
            $u->email = $data['email'];
            $u->password = Hash::make($data['password']);
            $u->email_verified_at = now(); // ✅ siempre verificado al crearlo
            $u->save();

            $u->syncRoles($data['roles'] ?? []);
            $u->syncPermissions($directToAssign);

            $this->user = $u;
            session()->flash('ok', 'Usuario creado.');
        }

        redirect()->to($this->redirect ?? route('users.index'));
    }

    public function render()
    {
        $guard = config('auth.defaults.guard', 'web');

        // Listado de roles disponibles (por guard)
        $allRoles = Role::query()
            ->where('guard_name', $guard)
            ->orderBy('name')
            ->pluck('name')
            ->toArray();

        // Listado de permisos disponibles (por guard)
        $allPerms = Permission::query()
            ->where('guard_name', $guard)
            ->orderBy('name')
            ->pluck('name')
            ->toArray();

        // Mapeo de etiquetas amigables
        $labels = $this->friendlyPermissionLabels();

        // ❌ No mostrar en "permisos directos" los que ya vienen heredados por rol
        $directCandidates = array_values(array_diff($allPerms, $this->inheritedPerms));

        $permOptions = array_map(function ($p) use ($labels) {
            return [
                'name'  => $p,
                'label' => $labels[$p] ?? $this->fallbackFriendly($p),
            ];
        }, $directCandidates);

        // Heredados (solo lectura)
        $inheritedOptions = array_map(function ($p) use ($labels) {
            return [
                'name'  => $p,
                'label' => $labels[$p] ?? $this->fallbackFriendly($p),
            ];
        }, $this->inheritedPerms);

        return view('livewire.users.form', [
            'allRoles'         => $allRoles,
            'permOptions'      => $permOptions,      // directos visibles/editables
            'inheritedOptions' => $inheritedOptions, // heredados por rol (solo lectura)
            'isEdit'           => (bool) ($this->user && $this->user->exists),
        ]);
    }

    /** Etiquetas "bonitas" -> ajusta a tu gusto */
    private function friendlyPermissionLabels(): array
    {
        return [
            // Users
            'users.view'   => 'Ver usuarios',
            'users.create' => 'Crear usuario',
            'users.update' => 'Editar usuario',
            'users.delete' => 'Eliminar usuario',
            // Doctors
            'doctors.view'   => 'Ver doctores',
            'doctors.create' => 'Crear doctor',
            'doctors.update' => 'Editar doctor',
            'doctors.delete' => 'Eliminar doctor',
            // Licenses
            'licenses.view'   => 'Ver licencias',
            'licenses.create' => 'Crear licencia',
            'licenses.update' => 'Editar licencia',
            'licenses.delete' => 'Eliminar licencia',
            // States
            'states.view'   => 'Ver estados',
            'states.create' => 'Crear estado',
            'states.update' => 'Editar estado',
            'states.delete' => 'Eliminar estado',
        ];
    }

    /** Fallback si el permiso no está en el mapa: "users.export_csv" -> "Users Export Csv" */
    private function fallbackFriendly(string $perm): string
    {
        $perm = str_replace(['.', '_'], ' ', $perm);
        return ucwords($perm);
    }
}
