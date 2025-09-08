<?php

namespace App\Livewire\States;

use App\Models\State;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, AuthorizesRequests;

    #[Url(as: 'q')] public string $search = '';
    #[Url] public string $operational = 'all'; // all, yes, no

    public function mount(): void
    {
        $this->authorize('viewAny', State::class);
    }

    public function updating($field): void
    {
        if (in_array($field, ['search','operational'])) {
            $this->resetPage();
        }
    }

    public function delete(int $id): void
    {
        $state = State::findOrFail($id);
        $this->authorize('delete', $state);

        // (Opcional) Evitar borrar si tiene licencias relacionadas:
        // if ($state->licenses()->exists()) {
        //     session()->flash('ok', 'No se puede eliminar: tiene licencias.');
        //     return;
        // }

        $state->delete();
        session()->flash('ok','Estado eliminado.');
    }

    public function render()
    {
        $term = "%{$this->search}%";

        $query = State::query()
            ->when($this->search, fn($q) =>
                $q->where('name','like',$term)->orWhere('code','like',$term)
            )
            ->when($this->operational !== 'all', fn($q) =>
                $q->where('is_operational', $this->operational === 'yes')
            )
            ->orderBy('name');

        return view('livewire.states.index', [
            'states' => $query->paginate(15),
        ]);
    }
}
