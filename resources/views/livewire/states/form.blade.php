<div class="max-w-xl p-6 space-y-6">
  <div class="flex items-center justify-between">
    <h1 class="text-xl font-semibold">
      {{ $isEdit ? 'Editar estado' : 'Nuevo estado' }}
    </h1>
    <a href="{{ $redirect ?? route('states.index') }}" class="text-sm underline">Volver</a>
  </div>

  @if (session('ok'))
    <div class="p-3 rounded bg-green-100 text-green-800 text-sm">{{ session('ok') }}</div>
  @endif

  <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="md:col-span-2">
      <label class="block text-xs font-medium mb-1">Nombre</label>
      <input type="text" wire:model.defer="name" class="w-full border rounded p-2 text-sm" required>
      @error('name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block text-xs font-medium mb-1">Código (2 letras)</label>
      <input type="text" wire:model.defer="code" class="w-full border rounded p-2 text-sm uppercase" maxlength="2" required>
      @error('code') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="flex items-center gap-2 mt-6">
      <input id="isop" type="checkbox" wire:model="is_operational" class="rounded border-gray-300">
      <label for="isop" class="text-sm">Operacional</label>
      @error('is_operational') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2 flex items-center gap-3">
      <button type="submit" class="px-4 py-2 rounded bg-gray-900 text-white text-sm">
        {{ $isEdit ? 'Guardar cambios' : 'Crear estado' }}
      </button>
      <a href="{{ $redirect ?? route('states.index') }}" class="text-sm underline">Cancelar</a>
    </div>
  </form>
</div>
