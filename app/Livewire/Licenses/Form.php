<?php

namespace App\Livewire\Licenses;

use App\Models\{Doctor, License, State};
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;

class Form extends Component
{
    use AuthorizesRequests;

    public ?License $license = null;

    public $doctor_id = '';
    public $state_id = '';
    public $issued_date = '';
    public $expiration_date = '';
    public $status = 'active';
    public $has_active_link = false;

    #[Url] public ?string $redirect = null;

    public function mount(?License $license = null): void
    {
        $this->license = $license;

        if ($this->license && $this->license->exists) {
            $this->authorize('update', $this->license);
            $this->fill([
                'doctor_id'       => $this->license->doctor_id,
                'state_id'        => $this->license->state_id,
                'issued_date'     => optional($this->license->issued_date)->format('Y-m-d'),
                'expiration_date' => optional($this->license->expiration_date)->format('Y-m-d'),
                'status'          => $this->license->status,
                'has_active_link' => (bool) $this->license->has_active_link,
            ]);
        } else {
            $this->authorize('create', License::class);

            $this->license = null;
            $this->doctor_id = '';
            $this->state_id = '';
            $this->issued_date = '';
            $this->expiration_date = '';
            $this->status = 'active';
            $this->has_active_link = false;
        }
    }

    protected function rules(): array
    {
        return [
            'doctor_id'       => ['required','integer','exists:doctors,id'],
            'state_id'        => [
                'required','integer',
                Rule::exists('states','id')->where(fn($q) => $q->where('is_operational', true)),
            ],
            'issued_date'     => ['nullable','date'],
            'expiration_date' => ['nullable','date','after_or_equal:issued_date'],
            'status'          => ['required','in:active,pending,expired'],
            'has_active_link' => ['boolean'],
        ];
    }

    protected $messages = [
        'doctor_id.required'             => 'Selecciona un doctor.',
        'state_id.required'              => 'Selecciona un estado.',
        'state_id.exists'                => 'El estado seleccionado no está operacional.',
        'expiration_date.after_or_equal' => 'La fecha de expiración no puede ser anterior a la de emisión.',
    ];

    public function save(): void
    {
        $data = $this->validate();

        $data['doctor_id'] = (int) $data['doctor_id'];
        $data['state_id']  = (int) $data['state_id'];
        $data['has_active_link'] = (bool) $data['has_active_link'];

        if ($this->license && $this->license->exists) {
            $this->license->update($data);
            session()->flash('ok', 'Licencia actualizada.');
        } else {
            $this->license = License::create($data);
            session()->flash('ok', 'Licencia creada.');
        }

        $this->runNotificationCommand($this->license);

        redirect()->to($this->redirect ?? route('licenses.index'));
    }

    private function runNotificationCommand(License $license): void
    {
        Artisan::call('licenses:send-reminders', ['--id' => $license->id]);
    }

    public function render()
    {
        $user = auth()->user();

        if ($user->hasRole('Doctor')) {
            // Doctor: solo se asigna a sí mismo
            $doctors = \App\Models\Doctor::where('user_id', $user->id)->with('user:id,name')->get();
            if (! $this->doctor_id) {
                $this->doctor_id = $doctors->first()?->id ?? '';
            }
        } else {
            // Admin / Front Desk / etc.
            $doctors = \App\Models\Doctor::with('user:id,name')->orderBy('id')->get();
        }

        return view('livewire.licenses.form', [
            'doctors' => $doctors,
            'states'  => State::where('is_operational', true)->orderBy('name')->get(),
            'isEdit'  => (bool) ($this->license && $this->license->exists),
        ]);
    }

}
