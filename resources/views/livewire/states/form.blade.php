<div class="max-w-xl p-6 space-y-6">
  <div class="flex items-center justify-between">
    <h1 class="text-xl font-semibold">
      {{ $isEdit ? 'Editar estado' : 'Nuevo estado' }}
    </h1>
    <a href="{{ $redirect ?? route('states.index') }}" class="text-sm flex items-center px-4 py-2 rounded-lg hover:bg-gray-100"><flux:icon name="arrow-uturn-left" class="h-4 w-4 mr-2" />Volver</a>
  </div>

  @if (session('ok'))
    <div class="p-3 rounded border-l-2 border-green-800 bg-green-100 text-green-800 text-sm flex items-center"><flux:icon name="bell" class="h-4 w-4 mr-4" />{{ session('ok') }}</div>
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

    <div class="flex justify-center items-center gap-2 mt-6">
      <input id="isop" type="checkbox" wire:model="is_operational" class="rounded border-gray-300">
      <label for="isop" class="text-sm">Operacional</label>
      @error('is_operational') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2 flex items-center gap-3 mt-5 justify-end">
      <button type="submit" class="flex items-center cursor-pointer px-3 py-2 text-neutral-50 rounded-lg group hover:shadow shadow-[#31353d] dark:shadow-[#4a4e58] bg-gradient-to-t active:bg-gradient-to-b from-[#6fa31c] to-[#123338] transition ease-in-out duration-300 text-sm hover:scale-105 font-semibold">
        {{ $isEdit ? 'Guardar cambios' : 'Crear estado' }}
      </button>
      <a href="{{ $redirect ?? route('states.index') }}" class="px-4 py-2 rounded-lg bg-gray-900 text-white transition ease-in-out duration-300 text-sm hover:scale-105 font-semibold">Cancelar</a>
    </div>
  </form>
</div>
