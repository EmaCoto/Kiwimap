<?php

namespace App\Livewire\Licenses;

use App\Models\{Doctor, License, State, User};
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
    public $status = '';
    public $has_active_link = false;

    #[Url] public ?string $redirect = null;

    public function mount(?License $license = null): void
    {
        $this->license = $license;

        if ($license && $license->exists) {
            $this->authorize('update', $license);

            $this->fill([
                'doctor_id' => $license->doctor_id,
                'state_id' => $license->state_id,
                'issued_date' => optional($license->issued_date)->format('Y-m-d'),
                'expiration_date' => optional($license->expiration_date)->format('Y-m-d'),
                'status' => License::normalizeStatus($license->status),
                'has_active_link' => (bool) $license->has_active_link,
            ]);
        } else {
            $this->authorize('create', License::class);
            $this->status = License::STATUS_ACTIVE;
        }
    }

    protected function rules(): array
    {
        $currentStateId = $this->license?->state_id;

        return [
            'doctor_id' => ['required', 'integer', 'exists:doctors,id'],
            'state_id' => [
                'required',
                'integer',
                Rule::exists('states', 'id')->where(function ($query) use ($currentStateId) {
                    $query->where('is_operational', true);

                    if ($currentStateId) {
                        $query->orWhere('id', $currentStateId);
                    }
                }),
            ],
            'issued_date' => ['required', 'date'],
            'expiration_date' => ['required', 'date', 'after_or_equal:issued_date'],
            'status' => ['required', Rule::in(License::canonicalStatuses())],
            'has_active_link' => ['boolean'],
        ];
    }

    protected $messages = [
        'doctor_id.required' => 'Selecciona un doctor.',
        'state_id.required' => 'Selecciona un estado.',
        'state_id.exists' => 'El estado seleccionado no esta disponible para esta licencia.',
        'issued_date.required' => 'La fecha de emision es obligatoria.',
        'expiration_date.required' => 'La fecha de expiracion es obligatoria.',
        'expiration_date.after_or_equal' => 'La fecha de expiracion no puede ser anterior a la de emision.',
        'status.required' => 'Selecciona un estado de licencia.',
    ];

    public function save(): void
    {
        $data = $this->validate();

        $data['doctor_id'] = (int) $data['doctor_id'];
        $data['state_id'] = (int) $data['state_id'];
        $data['has_active_link'] = (bool) $data['has_active_link'];

        if ($this->license && $this->license->exists) {
            $this->license->update($data);
            session()->flash('ok', 'Licencia actualizada.');
        } else {
            $this->license = License::query()->create($data);
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
        /** @var User|null $user */
        $user = request()->user();
        $currentStateId = $this->license?->state_id;

        abort_unless($user instanceof User, 403);

        if ($user->hasRole('Doctor')) {
            $doctors = Doctor::query()
                ->where('user_id', $user->id)
                ->with('user:id,name')
                ->get();

            if (! $this->doctor_id) {
                $this->doctor_id = $doctors->first()?->id ?? '';
            }
        } else {
            $doctors = Doctor::query()
                ->with('user:id,name')
                ->orderBy('id')
                ->get();
        }

        return view('livewire.licenses.form', [
            'doctors' => $doctors,
            'states' => State::query()
                ->where(function ($query) use ($currentStateId) {
                    $query->where('is_operational', true);

                    if ($currentStateId) {
                        $query->orWhere('id', $currentStateId);
                    }
                })
                ->orderByDesc('is_operational')
                ->orderBy('name')
                ->get(['id', 'name', 'code', 'is_operational']),
            'isEdit' => (bool) ($this->license && $this->license->exists),
        ]);
    }
}
