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

    // ⬇️ nuevos campos
    public ?string $employee_number = null;
    public bool $has_id_badge = false;
    public ?string $birthday = null;               // YYYY-MM-DD
    public ?string $anniversary_kiwimed = null;    // YYYY-MM-DD
    public ?string $anniversary_group = null;      // YYYY-MM-DD
    public ?string $country_code = null;           // 'us','co','mx'...
    public ?string $spruce_number = null;
    public ?string $crecer_number = null;

    public array $roles = [];
    public array $permissions = [];
    public array $inheritedPerms = [];

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
                'permissions' => $this->user->getDirectPermissions()->pluck('name')->toArray(),

                // nuevos
                'employee_number'     => $this->user->employee_number,
                'has_id_badge'        => (bool) $this->user->has_id_badge,
                'birthday'            => optional($this->user->birthday)->toDateString(),
                'anniversary_kiwimed' => optional($this->user->anniversary_kiwimed)->toDateString(),
                'anniversary_group'   => optional($this->user->anniversary_group)->toDateString(),
                'country_code'        => $this->user->country_code,
                'spruce_number'       => $this->user->spruce_number,
                'crecer_number'       => $this->user->crecer_number,
            ]);
        } else {
            $this->authorize('create', User::class);
            $this->user = null;
        }

        $this->recomputeInheritedPerms();
    }

    protected function rules(): array
    {
        $emailRule = Rule::unique('users','email')->ignore($this->user?->id);

        $base = [
            'name'         => ['required','string','max:190'],
            'email'        => ['required','email','max:190',$emailRule],
            'roles'        => ['array'],
            'roles.*'      => ['string','exists:roles,name'],
            'permissions'  => ['array'],
            'permissions.*'=> ['string','exists:permissions,name'],

            // nuevos (opcionales salvo formatos)
            'employee_number'     => ['nullable','string','max:50'],
            'has_id_badge'        => ['boolean'],
            'birthday'            => ['nullable','date'],
            'anniversary_kiwimed' => ['nullable','date'],
            'anniversary_group'   => ['nullable','date'],
            'country_code'        => ['nullable','string','size:2'], // ISO-2
            'spruce_number'       => ['nullable','string','max:50'],
            'crecer_number'       => ['nullable','string','max:50'],
        ];

        if ($this->user && $this->user->exists) {
            $base['password'] = ['nullable','string','min:8','confirmed'];
        } else {
            $base['password'] = ['required','string','min:8','confirmed'];
        }

        return $base;
    }

    protected $messages = [
        'email.unique' => 'Este email ya está registrado.',
    ];

    public function updatedRoles(): void
    {
        $this->recomputeInheritedPerms();
        $this->permissions = array_values(array_diff($this->permissions, $this->inheritedPerms));
    }

    private function recomputeInheritedPerms(): void
    {
        $guard = config('auth.defaults.guard', 'web');
        if (empty($this->roles)) { $this->inheritedPerms = []; return; }

        $this->inheritedPerms = Role::query()
            ->whereIn('name',$this->roles)->where('guard_name',$guard)
            ->with(['permissions'=>fn($q)=>$q->where('guard_name',$guard)->select('permissions.id','permissions.name','permissions.guard_name')])
            ->get()->flatMap(fn($r)=>$r->permissions->pluck('name'))->unique()->values()->toArray();
    }

    public function save(): void
    {
        $data = $this->validate();
        $directToAssign = array_values(array_diff($data['permissions'] ?? [], $this->inheritedPerms));

        if ($this->user && $this->user->exists) {
            $u = $this->user;
            $u->name  = $data['name'];
            $u->email = $data['email'];
            if (!empty($data['password'])) $u->password = Hash::make($data['password']);
            if (is_null($u->email_verified_at)) $u->email_verified_at = now();

            // nuevos
            $u->employee_number     = $data['employee_number'] ?? null;
            $u->has_id_badge        = (bool)($data['has_id_badge'] ?? false);
            $u->birthday            = $data['birthday'] ?? null;
            $u->anniversary_kiwimed = $data['anniversary_kiwimed'] ?? null;
            $u->anniversary_group   = $data['anniversary_group'] ?? null;
            $u->country_code        = $data['country_code'] ? strtolower($data['country_code']) : null;
            $u->spruce_number       = $data['spruce_number'] ?? null;
            $u->crecer_number       = $data['crecer_number'] ?? null;

            $u->save();
            $u->syncRoles($data['roles'] ?? []);
            $u->syncPermissions($directToAssign);
            session()->flash('ok','Usuario actualizado.');
        } else {
            $u = new User();
            $u->name  = $data['name'];
            $u->email = $data['email'];
            $u->password = Hash::make($data['password']);
            $u->email_verified_at = now();

            $u->employee_number     = $data['employee_number'] ?? null;
            $u->has_id_badge        = (bool)($data['has_id_badge'] ?? false);
            $u->birthday            = $data['birthday'] ?? null;
            $u->anniversary_kiwimed = $data['anniversary_kiwimed'] ?? null;
            $u->anniversary_group   = $data['anniversary_group'] ?? null;
            $u->country_code        = $data['country_code'] ? strtolower($data['country_code']) : null;
            $u->spruce_number       = $data['spruce_number'] ?? null;
            $u->crecer_number       = $data['crecer_number'] ?? null;

            $u->save();
            $u->syncRoles($data['roles'] ?? []);
            $u->syncPermissions($directToAssign);
            $this->user = $u;
            session()->flash('ok','Usuario creado.');
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
