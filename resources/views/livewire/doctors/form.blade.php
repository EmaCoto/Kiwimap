<div class="max-w-2xl p-6 space-y-6">
  <div class="flex items-center justify-between">
    <h1 class="text-xl font-semibold">
      {{ $isEdit ? 'Editar doctor' : 'Nuevo doctor' }}
    </h1>
    <a href="{{ $redirect ?? route('doctors.index') }}" class="text-sm flex items-center px-4 py-2 rounded-lg hover:bg-gray-100"><flux:icon name="arrow-uturn-left" class="h-4 w-4 mr-2" />Volver</a>
  </div>

  @if (session('ok'))
    <div class="p-3 rounded border-l-2 border-green-800 bg-green-100 text-green-800 text-sm flex items-center"><flux:icon name="bell" class="h-4 w-4 mr-4" />{{ session('ok') }}</div>
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

    <div class="md:col-span-2 flex items-center gap-3 mt-5 justify-end">
      <button type="submit" class="flex items-center cursor-pointer px-3 py-2 text-neutral-50 rounded-lg group hover:shadow shadow-[#31353d] dark:shadow-[#4a4e58] bg-gradient-to-t active:bg-gradient-to-b from-[#6fa31c] to-[#123338] transition ease-in-out duration-300 text-sm hover:scale-105 font-semibold">
        {{ $isEdit ? 'Guardar cambios' : 'Crear doctor' }}
      </button>
      <a href="{{ $redirect ?? route('doctors.index') }}" class="px-4 py-2 rounded-lg bg-gray-900 text-white transition ease-in-out duration-300 text-sm hover:scale-105 font-semibold">Cancelar</a>
    </div>
  </form>
</div>
