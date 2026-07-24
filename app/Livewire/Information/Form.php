<?php

namespace App\Livewire\Information;

use App\Models\Information\Index as InformationIndex;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Url;
use Livewire\Component;

class Form extends Component
{
    use AuthorizesRequests;

    public ?InformationIndex $informationRecord = null;

    public string $name = '';
    public string $information = '';
    public ?string $notes = null;

    #[Url]
    public ?string $redirect = null;

    public function mount(?InformationIndex $informationRecord = null): void
    {
        $this->informationRecord = $informationRecord;

        if ($this->informationRecord?->exists) {
            $this->authorize('update', $this->informationRecord);
            $this->fill([
                'name' => $this->informationRecord->name,
                'information' => $this->informationRecord->information,
                'notes' => $this->informationRecord->notes,
            ]);

            return;
        }

        $this->authorize('create', InformationIndex::class);
        $this->informationRecord = null;
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'information' => ['required', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
        ];
    }

    protected $messages = [
        'name.required' => 'Ingresa un nombre.',
        'name.max' => 'El nombre no puede superar los 150 caracteres.',
        'information.required' => 'Ingresa la información.',
        'information.max' => 'La información no puede superar los 100 caracteres.',
    ];

    public function save(): void
    {
        $data = $this->validate();
        $data['name'] = trim($data['name']);
        $data['information'] = trim($data['information']);
        $data['notes'] = filled($data['notes'] ?? null) ? trim($data['notes']) : null;

        if ($this->informationRecord?->exists) {
            $this->authorize('update', $this->informationRecord);
            $this->informationRecord->update($data);
            session()->flash('ok', 'Información actualizada.');
        } else {
            $this->authorize('create', InformationIndex::class);
            $this->informationRecord = InformationIndex::create($data);
            session()->flash('ok', 'Información creada.');
        }

        redirect()->to($this->redirect ?? route('information.index'));
    }

    public function render()
    {
        return view('livewire.information.form', [
            'isEdit' => (bool) $this->informationRecord?->exists,
        ]);
    }
}
