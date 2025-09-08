<?php

namespace App\Livewire\States;

use App\Models\State;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;

class Form extends Component
{
    use AuthorizesRequests;

    public ?State $state = null;

    public $name = '';
    public $code = '';
    public $is_operational = true;

    #[Url] public ?string $redirect = null;

    public function mount(?State $state = null): void
    {
        $this->state = $state;

        if ($this->state && $this->state->exists) {
            $this->authorize('update', $this->state);
            $this->fill([
                'name'           => $this->state->name,
                'code'           => $this->state->code,
                'is_operational' => (bool) $this->state->is_operational,
            ]);
        } else {
            $this->authorize('create', State::class);

            $this->state = null;
            $this->name = '';
            $this->code = '';
            $this->is_operational = true;
        }
    }

    protected function rules(): array
    {
        return [
            'name' => ['required','string','max:100'],
            'code' => [
                'required','string','size:2',
                Rule::unique('states','code')->ignore($this->state?->id),
            ],
            'is_operational' => ['required','boolean'],
        ];
    }

    protected $messages = [
        'name.required' => 'Ingresa el nombre del estado.',
        'code.required' => 'Ingresa el código (2 letras).',
        'code.size'     => 'El código debe tener exactamente 2 caracteres.',
        'code.unique'   => 'Ese código ya existe.',
    ];

    public function save(): void
    {
        $data = $this->validate();

        // Normaliza CODE a mayúsculas y sin espacios
        $data['code'] = strtoupper(trim($data['code']));
        $data['is_operational'] = (bool) $data['is_operational'];

        if ($this->state && $this->state->exists) {
            $this->state->update($data);
            session()->flash('ok','Estado actualizado.');
        } else {
            $this->state = State::create($data);
            session()->flash('ok','Estado creado.');
        }

        redirect()->to($this->redirect ?? route('states.index'));
    }

    public function render()
    {
        return view('livewire.states.form', [
            'isEdit' => (bool) ($this->state && $this->state->exists),
        ]);
    }
}
