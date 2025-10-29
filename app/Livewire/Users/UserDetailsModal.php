<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\On;
use Livewire\Component;

class UserDetailsModal extends Component
{
    use AuthorizesRequests;

    public ?User $user = null;
    public bool $open = false;

    #[On('open-user-details')]
    public function open(int $userId): void
    {
        $this->user = User::findOrFail($userId);
        $this->authorize('view', $this->user);
        $this->open = true;
    }

    public function close(): void { $this->open = false; }

    private function val(?string $value, string $placeholder = '—'): string
    {
        return $value !== null && $value !== '' ? $value : $placeholder;
    }

    public function render()
    {
        return view('livewire.users.user-details-modal');
    }
}
