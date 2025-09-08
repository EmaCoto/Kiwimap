<div class="max-w-2xl p-6 space-y-6">
  <div class="flex items-center justify-between">
    <h1 class="text-xl font-semibold">
      {{ $isEdit ? 'Editar doctor' : 'Nuevo doctor' }}
    </h1>
    <a href="{{ $redirect ?? route('doctors.index') }}" class="text-sm underline">Volver</a>
  </div>

  @if (session('ok'))
    <div class="p-3 rounded bg-green-100 text-green-800 text-sm">{{ session('ok') }}</div>
  @endif

  <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="md:col-span-2">
      <label class="block text-xs font-medium mb-1">Usuario</label>
      <select wire:model="user_id" class="w-full border rounded p-2 text-sm" required>
        <option value="">Seleccione…</option>
        @foreach($users as $u)
          <option value="{{ $u->id }}">{{ $u->name }} — {{ $u->email }}</option>
        @endforeach
      </select>
      @error('user_id') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
      <label class="block text-xs font-medium mb-1">Especialidad (opcional)</label>
      <input type="text" wire:model.defer="specialty" class="w-full border rounded p-2 text-sm" placeholder="Family Medicine, Psychiatry…">
      @error('specialty') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2 flex items-center gap-3">
      <button type="submit" class="px-4 py-2 rounded bg-gray-900 text-white text-sm">
        {{ $isEdit ? 'Guardar cambios' : 'Crear doctor' }}
      </button>
      <a href="{{ $redirect ?? route('doctors.index') }}" class="text-sm underline">Cancelar</a>
    </div>
  </form>
</div>
