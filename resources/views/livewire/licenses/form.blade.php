<div class="max-w-2xl p-6 space-y-6">
  <div class="flex items-center justify-between">
    <h1 class="text-xl font-semibold">
      {{ $isEdit ? 'Editar licencia' : 'Nueva licencia' }}
    </h1>
    <a href="{{ $redirect ?? route('licenses.index') }}" class="text-sm underline">Volver</a>
  </div>

  @if (session('ok'))
    <div class="p-3 rounded bg-green-100 text-green-800 text-sm">{{ session('ok') }}</div>
  @endif

  <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-xs font-medium mb-1">Doctor</label>
        <select wire:model="doctor_id" class="w-full border rounded p-2 text-sm">
          <option value="">Seleccione…</option>
          @foreach($doctors as $d)
            <option value="{{ $d->id }}">
              {{ $d->user?->name }}{{ $d->specialty ? ' — '.$d->specialty : '' }}
            </option>
          @endforeach
        </select>
      @error('doctor_id') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block text-xs font-medium mb-1">Estado</label>
      <select wire:model="state_id" class="w-full border rounded p-2 text-sm">
        <option value="">Seleccione…</option>
        @foreach($states as $s)
          <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->code }})</option>
        @endforeach
      </select>
      @error('state_id') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block text-xs font-medium mb-1">License #</label>
      <input type="text" wire:model.defer="license_number" class="w-full border rounded p-2 text-sm">
      @error('license_number') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block text-xs font-medium mb-1">Tipo (MD/DO/APRN/PA)</label>
      <input type="text" wire:model.defer="license_type" class="w-full border rounded p-2 text-sm">
      @error('license_type') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block text-xs font-medium mb-1">Emitida</label>
      <input type="date" wire:model="issued_date" class="w-full border rounded p-2 text-sm">
      @error('issued_date') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block text-xs font-medium mb-1">Expira</label>
      <input type="date" wire:model="expiration_date" class="w-full border rounded p-2 text-sm">
      @error('expiration_date') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block text-xs font-medium mb-1">Status</label>
      <select wire:model="status" class="w-full border rounded p-2 text-sm">
        <option value="active">Activa</option>
        <option value="pending">Pendiente</option>
        <option value="expired">Vencida</option>
      </select>
      @error('status') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block text-xs font-medium mb-1">Link verificación</label>
      <input type="url" wire:model.defer="active_license_link" placeholder="https://..." class="w-full border rounded p-2 text-sm">
      @error('active_license_link') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
      <label class="block text-xs font-medium mb-1">DEA # (opcional)</label>
      <input type="text" wire:model.defer="dea_number" class="w-full border rounded p-2 text-sm">
      @error('dea_number') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2 flex items-center gap-3">
      <button type="submit" class="px-4 py-2 rounded bg-gray-900 text-white text-sm">
        {{ $isEdit ? 'Guardar cambios' : 'Crear licencia' }}
      </button>
      <a href="{{ $redirect ?? route('licenses.index') }}" class="text-sm underline">Cancelar</a>
    </div>
  </form>
</div>
