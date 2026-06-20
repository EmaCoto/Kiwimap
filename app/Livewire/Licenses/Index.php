<?php

namespace App\Livewire\Licenses;

use App\Models\{License, State, User};
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, AuthorizesRequests;

    #[Url(as: 'state')] public string $stateCode = '';
    #[Url] public string $status = 'all';
    #[Url(as: 'q')] public string $search = '';

    public function mount(): void
    {
        $this->authorize('viewAny', License::class);
        $this->status = License::normalizeStatus($this->status) ?? $this->status;
    }

    public function updating($field): void
    {
        if (in_array($field, ['stateCode', 'status', 'search'], true)) {
            $this->resetPage();
        }
    }

    public function clearFilters(): void
    {
        $this->stateCode = '';
        $this->status = 'all';
        $this->search = '';
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        $license = License::query()->with('doctor.user')->findOrFail($id);
        $this->authorize('delete', $license);
        $license->delete();

        session()->flash('ok', 'Licencia eliminada.');
    }

    public function render()
    {
        /** @var User|null $user */
        $user = request()->user();

        $query = License::query()
            ->when($this->stateCode, fn ($q) =>
                $q->whereHas('state', fn ($s) => $s->where('code', strtoupper($this->stateCode)))
            )
            ->forStatus($this->status)
            ->when($this->search, function ($q) {
                $term = "%{$this->search}%";

                $q->where(function ($qq) use ($term) {
                    $qq->whereHas('doctor.user', fn ($u) => $u->where('name', 'like', $term))
                        ->orWhereHas('state', fn ($s) => $s->where('name', 'like', $term)->orWhere('code', 'like', $term));
                });
            })
            ->visibleToUser($user)
            ->with(['doctor.user', 'state'])
            ->orderByDesc('expiration_date')
            ->orderByDesc('id');

        return view('livewire.licenses.index', [
            'licenses' => $query->paginate(15),
            'states' => State::query()
                ->orderByDesc('is_operational')
                ->orderBy('name')
                ->get(['id', 'name', 'code', 'is_operational']),
        ]);
    }
}
