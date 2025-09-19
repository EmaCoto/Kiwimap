<div class="max-w-2xl p-6 space-y-6">
  <div class="flex items-center justify-between">
    <h1 class="text-xl font-semibold">
      {{ $isEdit ? 'Editar licencia' : 'Nueva licencia' }}
    </h1>
    <a href="{{ $redirect ?? route('licenses.index') }}" class="text-sm flex items-center px-4 py-2 rounded-lg hover:bg-gray-100"><flux:icon name="arrow-uturn-left" class="h-4 w-4 mr-2" />Volver</a>
  </div>

  @if (session('ok'))
    <div class="p-3 rounded border-l-2 border-green-800 bg-green-100 text-green-800 text-sm flex items-center"><flux:icon name="bell" class="h-4 w-4 mr-4" />sdsd{{ session('ok') }}</div>
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

    <div class="flex justify-center items-center gap-2 mt-6">
      <input id="has_link" type="checkbox" wire:model="has_active_link" class="rounded border-gray-300">
      <label for="has_link" class="text-sm">Tiene link de verificación</label>
    </div>

    <div class="md:col-span-2 flex items-center gap-3 mt-5 justify-end">
      <button type="submit" class="flex items-center cursor-pointer px-3 py-2 text-neutral-50 rounded-lg group hover:shadow shadow-[#31353d] dark:shadow-[#4a4e58] bg-gradient-to-t active:bg-gradient-to-b from-[#6fa31c] to-[#123338] transition ease-in-out duration-300 text-sm hover:scale-105 font-semibold"">
        {{ $isEdit ? 'Guardar cambios' : 'Crear licencia' }}
      </button>
      <a href="{{ $redirect ?? route('licenses.index') }}" class="px-4 py-2 rounded-lg bg-gray-900 text-white transition ease-in-out duration-300 text-sm hover:scale-105 font-semibold">Cancelar</a>
    </div>
  </form>
</div>
