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

    public array $roles = [];
    public array $permissions = [];

    public bool $email_verified = true;

    #[Url] public ?string $redirect = null;

    public function mount(?User $user = null): void
    {
        $this->user = $user;

        if ($this->user && $this->user->exists) {
            $this->authorize('update', $this->user);

            $this->fill([
                'name'  => $this->user->name,
                'email' => $this->user->email,
                'roles' => $this->user->roles()->pluck('name')->toArray(),
                'permissions' => $this->user->permissions()->pluck('name')->toArray(),
                'email_verified' => !is_null($this->user->email_verified_at),
            ]);
        } else {
            $this->authorize('create', User::class);
            $this->user = null;
            $this->email_verified = true; // por defecto verificado (ajústalo a tu flow)
        }
    }

    protected function rules(): array
    {
        $emailRule = Rule::unique('users','email')->ignore($this->user?->id);

        $base = [
            'name'  => ['required','string','max:190'],
            'email' => ['required','email','max:190', $emailRule],
            'roles' => ['array'],
            'roles.*' => ['string','exists:roles,name'],
            'permissions' => ['array'],
            'permissions.*' => ['string','exists:permissions,name'],
            'email_verified' => ['boolean'],
        ];

        if ($this->user && $this->user->exists) {
            // update: password opcional
            $base['password'] = ['nullable','string','min:8','confirmed'];
        } else {
            // create: password requerido
            $base['password'] = ['required','string','min:8','confirmed'];
        }

        return $base;
    }

    protected $messages = [
        'name.required' => 'Ingresa un nombre.',
        'email.required'=> 'Ingresa un email.',
        'email.email'   => 'Email inválido.',
        'email.unique'  => 'Este email ya está registrado.',
        'password.required'  => 'Ingresa una contraseña.',
        'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
        'password.confirmed' => 'Las contraseñas no coinciden.',
    ];

    public function save(): void
    {
        $data = $this->validate();

        if ($this->user && $this->user->exists) {
            // UPDATE
            $this->user->name  = $data['name'];
            $this->user->email = $data['email'];

            if (!empty($data['password'])) {
                $this->user->password = Hash::make($data['password']);
            }

            $this->user->email_verified_at = $data['email_verified'] ? now() : null;
            $this->user->save();

            // Roles & permisos
            $this->user->syncRoles($data['roles'] ?? []);
            $this->user->syncPermissions($data['permissions'] ?? []);

            session()->flash('ok', 'Usuario actualizado.');
        } else {
            // CREATE
            $u = new User();
            $u->name  = $data['name'];
            $u->email = $data['email'];
            $u->password = Hash::make($data['password']);
            $u->email_verified_at = $data['email_verified'] ? now() : null;
            $u->save();

            $u->syncRoles($data['roles'] ?? []);
            $u->syncPermissions($data['permissions'] ?? []);

            $this->user = $u;
            session()->flash('ok', 'Usuario creado.');
        }

        redirect()->to($this->redirect ?? route('users.index'));
    }

    public function render()
    {
        $guard = config('auth.defaults.guard', 'web');

        return view('livewire.users.form', [
            'allRoles' => \Spatie\Permission\Models\Role::query()
                ->where('guard_name', $guard)
                ->orderBy('name')
                ->pluck('name')
                ->toArray(),

            'allPerms' => \Spatie\Permission\Models\Permission::query()
                ->where('guard_name', $guard)
                ->orderBy('name')
                ->pluck('name')
                ->toArray(),

            'isEdit'   => (bool) ($this->user && $this->user->exists),
        ]);
    }

}
