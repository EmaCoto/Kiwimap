<?php

namespace App\Livewire\Doctors;

use App\Models\Doctor;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, AuthorizesRequests;

    #[Url(as: 'q')] public string $search = '';

    public function mount(): void
    {
        $this->authorize('viewAny', Doctor::class);
    }

    public function updating($field): void
    {
        if ($field === 'search') $this->resetPage();
    }

    public function delete(int $id): void
    {
        $doctor = Doctor::with('user')->findOrFail($id);
        $this->authorize('delete', $doctor);
        $doctor->delete();
        session()->flash('ok', 'Doctor eliminado.');
    }

    public function render()
    {
        $term = "%{$this->search}%";

        $query = Doctor::query()
            ->with('user:id,name,email')
            ->when($this->search, function ($q) use ($term) {
                $q->whereHas('user', fn($u) => $u->where('name','like',$term)
                                                ->orWhere('email','like',$term))
                  ->orWhere('specialty','like',$term);
            })
            ->orderBy('id','desc');

        return view('livewire.doctors.index', [
            'doctors' => $query->paginate(15),
        ]);
    }
}
