<?php

namespace App\Livewire\Licenses;

use App\Models\{License, State};
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
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
    }

    public function updating($field): void
    {
        if (in_array($field, ['stateCode','status','search'])) {
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
        $license = License::with('doctor.user')->findOrFail($id);
        $this->authorize('delete', $license);
        $license->delete();

        session()->flash('ok', 'License eliminada.');
    }

    public function render()
    {
        $query = License::query()
            ->whereHas('state', fn($s) => $s->where('is_operational', true))
            ->when($this->stateCode, fn($q) =>
                $q->whereHas('state', fn($s) => $s->where('code', strtoupper($this->stateCode))->where('is_operational', true))
            )
            ->when($this->status !== 'all', fn($q) => $q->where('status', $this->status))
            ->when($this->search, function ($q) {
                $term = "%{$this->search}%";
                $q->where(function ($qq) use ($term) {
                    $qq->whereHas('doctor.user', fn($u) => $u->where('name','like',$term))
                    ->orWhereHas('state', fn($s) => $s->where('name','like',$term)->orWhere('code','like',$term));
                });
            })
            ->with(['doctor.user','state'])
            ->orderByDesc('expiration_date');

        // 🔒 Si el usuario es Doctor → solo sus licencias
            if (Auth::user()?->hasRole('Doctor')) {
                $query->whereHas('doctor', fn($d) => $d->where('user_id', Auth::id()));
            }
        return view('livewire.licenses.index', [
            'licenses' => $query->paginate(15),
            'states'   => State::where('is_operational', true)->orderBy('name')->get(['id','name','code']),
        ]);
    }

}
