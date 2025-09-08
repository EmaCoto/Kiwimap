<?php

namespace App\Livewire\Doctors;

use App\Models\{Doctor, User};
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;

class Form extends Component
{
    use AuthorizesRequests;

    public ?Doctor $doctor = null;

    public $user_id = '';
    public $specialty = '';

    #[Url] public ?string $redirect = null;

    public function mount(?Doctor $doctor = null): void
    {
        $this->doctor = $doctor;

        if ($this->doctor && $this->doctor->exists) {
            $this->authorize('update', $this->doctor);
            $this->fill([
                'user_id'   => $this->doctor->user_id,
                'specialty' => $this->doctor->specialty,
            ]);
        } else {
            $this->authorize('create', Doctor::class);

            $this->doctor = null;
            $this->user_id = '';
            $this->specialty = '';
        }
    }

    protected function rules(): array
    {
        return [
            'user_id'   => ['required','integer','exists:users,id',
                Rule::unique('doctors','user_id')->ignore($this->doctor?->id)
            ],
            'specialty' => ['nullable','string','max:100'],
        ];
    }

    protected $messages = [
        'user_id.required' => 'Selecciona el usuario del médico.',
        'user_id.unique'   => 'Este usuario ya está asociado a un doctor.',
    ];

    public function save(): void
    {
        $data = $this->validate();
        $data['user_id'] = (int) $data['user_id'];

        if ($this->doctor && $this->doctor->exists) {
            $this->doctor->update($data);
            session()->flash('ok','Doctor actualizado.');
        } else {
            $this->doctor = Doctor::create($data);
            session()->flash('ok','Doctor creado.');
        }

        redirect()->to($this->redirect ?? route('doctors.index'));
    }

    public function render()
    {
        // Mostrar usuarios no asignados + el actual si estás editando
        $users = User::query()
            ->select('id','name','email')
            ->when(!$this->doctor?->exists, fn($q) =>
                $q->whereNotIn('id', Doctor::pluck('user_id'))
            )
            ->orWhere('id', $this->doctor?->user_id ?? 0)
            ->orderBy('name')
            ->get()
            ->unique('id');

        return view('livewire.doctors.form', [
            'users'  => $users,
            'isEdit' => (bool) ($this->doctor && $this->doctor->exists),
        ]);
    }
}
