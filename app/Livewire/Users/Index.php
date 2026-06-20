<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    use WithPagination, AuthorizesRequests;

    #[Url(as: 'q')] public string $search = '';
    #[Url(as: 'role')] public string $roleName = '';

    public function mount(): void
    {
        $this->authorize('viewAny', User::class);
    }

    public function updating($field): void
    {
        if (in_array($field, ['search', 'roleName'], true)) {
            $this->resetPage();
        }
    }

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

        if (Auth::check() && (int) Auth::id() === (int) $user->id) {
            session()->flash('error', 'No puedes eliminar tu propio usuario.');
            return;
        }

        $user->delete();
        session()->flash('ok', 'Usuario eliminado.');
    }

    public function render()
    {
        $q = trim($this->search);

        $users = User::query()
            ->when($this->roleName, fn ($query) =>
                $query->whereHas('roles', fn ($roleQuery) => $roleQuery->where('name', $this->roleName))
            )
            ->when($q, function ($query) use ($q) {
                $term = "%{$q}%";

                $query->where(function ($innerQuery) use ($q, $term) {
                    if (is_numeric($q)) {
                        $innerQuery->orWhere('id', (int) $q);
                    }

                    $innerQuery->orWhere('name', 'like', $term)
                        ->orWhere('email', 'like', $term)
                        ->orWhereHas('roles', fn ($roleQuery) => $roleQuery->where('name', 'like', $term));
                });
            })
            ->with('roles:id,name')
            ->orderBy('name')
            ->paginate(12);

        $roles = Role::orderBy('name')->get(['id', 'name']);

        return view('livewire.users.index', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}