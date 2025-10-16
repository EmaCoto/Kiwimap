<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Users\AttendanceModal;
use Illuminate\Support\Facades\Auth; // 👈 importa esto

class Index extends Component
{
    use WithPagination, AuthorizesRequests;

    #[Url(as: 'q')] public string $search = '';

    public function mount(): void
    {
        $this->authorize('viewAny', User::class);
    }

    public function updating($field): void
    {
        if ($field === 'search') $this->resetPage();
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
            ->when($q, function ($query) use ($q) {
                $term = "%{$q}%";
                $query->where('name','like',$term)
                      ->orWhere('email','like',$term)
                      ->orWhereHas('roles', fn($r) => $r->where('name','like',$term));
            })
            ->with('roles:id,name')
            ->orderBy('name')
            ->paginate(12);

        return view('livewire.users.index', [
            'users' => $users,
        ]);
    }
}
