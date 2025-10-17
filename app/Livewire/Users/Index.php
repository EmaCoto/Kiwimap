<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Users\AttendanceModal;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role; // 👈 NECESARIO para los filtros de rol

class Index extends Component
{
    use WithPagination, AuthorizesRequests;

    #[Url(as: 'q')] public string $search = '';
    #[Url(as: 'role')] public string $roleName = ''; // 👈 NUEVA PROPIEDAD PARA FILTRAR POR ROL

    public function mount(): void
    {
        $this->authorize('viewAny', User::class);
    }

    public function updating($field): void
    {
        // Asegúrate de resetear la paginación para el filtro de rol también
        if (in_array($field, ['search', 'roleName'])) {
            $this->resetPage();
        }
    }

    // 👈 NUEVO MÉTODO PARA LIMPIAR FILTROS (Buena práctica)
    public function clearFilters(): void
    {
        $this->roleName = '';
        $this->search = '';
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        $user = User::findOrFail($id);
        $this->authorize('delete', $user);

        // Protección extra: no permitir eliminarse a sí mismo
        if (Auth::check() && (int) Auth::id() === (int) $user->id) {
            session()->flash('error', 'No puedes eliminar tu propio usuario.');
            return;
        }

        $user->delete();
        session()->flash('ok', 'Usuario eliminado.');
    }


    public function openAttendance(int $userId): void
    {
        // enviamos el evento directamente al componente AttendanceModal
        $this->dispatch('open-attendance', userId: $userId)
            ->to(AttendanceModal::class);
    }


    public function render()
    {
        $q = trim($this->search);

        $users = User::query()
            // 1. FILTRO POR ROL
            ->when($this->roleName, fn($query) => 
                $query->whereHas('roles', fn($r) => $r->where('name', $this->roleName))
            )
            
            // 2. FILTRO DE BÚSQUEDA GENERAL (ID, Nombre, Email, Rol)
            ->when($q, function ($query) use ($q) {
                $term = "%{$q}%";
                $query->where(function ($qq) use ($q, $term) {

                    // Buscar por ID de Usuario (si es un número)
                    if (is_numeric($q)) {
                        $qq->orWhere('id', (int) $q);
                    }

                    // Buscar por Nombre o Email
                    $qq->orWhere('name','like',$term)
                      ->orWhere('email','like',$term)
                    
                    // Buscar por Rol (Nombre)
                      ->orWhereHas('roles', fn($r) => $r->where('name','like',$term));
                });
            })
            ->with('roles:id,name')
            ->orderBy('name')
            ->paginate(12);

        // Obtenemos todos los roles disponibles para el dropdown en la vista
        $roles = Role::orderBy('name')->get(['id', 'name']);

        return view('livewire.users.index', [
            'users' => $users,
            'roles' => $roles, // 👈 Pasamos los roles a la vista
        ]);
    }
}