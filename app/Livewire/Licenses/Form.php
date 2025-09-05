<?php

namespace App\Livewire\Licenses;

use App\Models\{Doctor, License, State};
use Illuminate\Validation\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Form extends Component
{
    use AuthorizesRequests;

    public ?License $license = null;

    // Campos del formulario
    public $doctor_id = '';
    public $state_id = '';
    public $license_number = '';
    public $license_type = '';
    public $issued_date = '';
    public $expiration_date = '';
    public $status = 'active';
    public $active_license_link = '';
    public $dea_number = '';

    #[Url] public ?string $redirect = null;

    public function mount(?License $license = null): void
    {
        $this->license = $license;

        if ($this->license && $this->license->exists) {
            $this->authorize('update', $this->license);
            $this->fill([
                'doctor_id'          => $this->license->doctor_id,
                'state_id'           => $this->license->state_id,
                'license_number'     => $this->license->license_number,
                'license_type'       => $this->license->license_type,
                'issued_date'        => optional($this->license->issued_date)->format('Y-m-d'),
                'expiration_date'    => optional($this->license->expiration_date)->format('Y-m-d'),
                'status'             => $this->license->status,
                'active_license_link'=> $this->license->active_license_link,
                'dea_number'         => $this->license->dea_number,
            ]);
        } else {
            // Modo CREATE: permisos + estado limpio
            $this->authorize('create', License::class);

            $this->license = null;
            $this->doctor_id = '';
            $this->state_id = '';
            $this->license_number = '';
            $this->license_type = '';
            $this->issued_date = '';
            $this->expiration_date = '';
            $this->status = 'active';
            $this->active_license_link = '';
            $this->dea_number = '';
        }
    }



    protected function rules(): array
    {
        // OJO: unique alineado al índice compuesto doctor_id + state_id + license_number
        $uniqueComposite = Rule::unique('licenses', 'license_number')
            ->where(fn ($q) => $q
                ->where('doctor_id', $this->doctor_id ?: 0)
                ->where('state_id',  $this->state_id ?: 0)
            )
            ->ignore($this->license?->id);

        return [
            'doctor_id'          => ['required','integer','exists:doctors,id'],
            'state_id'           => ['required','integer','exists:states,id'],
            'license_number'     => ['required','string','max:190', $uniqueComposite],
            'license_type'       => ['nullable','string','max:50'],
            'issued_date'        => ['nullable','date'],
            'expiration_date'    => ['nullable','date','after_or_equal:issued_date'],
            'status'             => ['required','in:active,pending,expired'],
            'active_license_link'=> ['nullable','url'],
            'dea_number'         => ['nullable','string','max:50'],
        ];
    }

    protected $messages = [
        'doctor_id.required' => 'Selecciona un doctor.',
        'state_id.required'  => 'Selecciona un estado.',
        'license_number.required' => 'Ingresa el número de licencia.',
        'license_number.unique'   => 'Ya existe una licencia con ese número para ese doctor y estado.',
        'active_license_link.url' => 'El enlace debe ser una URL válida.',
        'expiration_date.after_or_equal' => 'La fecha de expiración no puede ser anterior a la de emisión.',
    ];

    public function save(): void
    {
        $data = $this->validate();

        $data['doctor_id'] = (int) $data['doctor_id'];
        $data['state_id']  = (int) $data['state_id'];

        if ($this->license && $this->license->exists) {
            $this->license->update($data);
            session()->flash('ok', 'Licencia actualizada.');
        } else {
            $this->license = License::create($data);
            session()->flash('ok', 'Licencia creada.');
        }

        redirect()->to($this->redirect ?? route('licenses.index'));
    }


    public function render()
    {
        return view('livewire.licenses.form', [
            'doctors' => Doctor::with('user:id,name')->orderBy('id')->get(),
            'states'  => State::orderBy('name')->get(),
            'isEdit'  => (bool) ($this->license && $this->license->exists),
        ]);
    }
}
