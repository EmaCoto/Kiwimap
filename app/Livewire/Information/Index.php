<?php

namespace App\Livewire\Information;

use App\Models\Information\Index as InformationIndex;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use AuthorizesRequests, WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    public function mount(): void
    {
        $this->authorize('viewAny', InformationIndex::class);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        $record = InformationIndex::findOrFail($id);
        $this->authorize('delete', $record);

        $record->delete();
        session()->flash('ok', 'Información eliminada.');
    }

    public function render()
    {
        $term = '%'.$this->search.'%';

        $records = InformationIndex::query()
            ->when($this->search !== '', function ($query) use ($term) {
                $query->where(function ($query) use ($term) {
                    $query->where('name', 'like', $term)
                        ->orWhere('information', 'like', $term)
                        ->orWhere('notes', 'like', $term);
                });
            })
            ->latest()
            ->paginate(15);

        return view('livewire.information.index', [
            'records' => $records,
        ]);
    }
}
