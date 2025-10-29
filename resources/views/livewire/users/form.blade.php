<div class="max-w-3xl p-6 space-y-6">
  <div class="flex items-center justify-between">
    <h1 class="text-xl font-semibold">
      {{ $isEdit ? 'Editar usuario' : 'Nuevo usuario' }}
    </h1>
    <a href="{{ $redirect ?? route('users.index') }}" class="text-sm flex items-center px-4 py-2 rounded-lg hover:bg-gray-100"><flux:icon name="arrow-uturn-left" class="h-4 w-4 mr-2" />Volver</a>
  </div>

  @if (session('ok'))
    <div class="p-3 rounded bg-green-100 text-green-800 text-sm">{{ session('ok') }}</div>
  @endif

  <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="md:col-span-2">
      <label class="block text-xs font-medium mb-1">Nombre</label>
      <input type="text" wire:model.defer="name" class="w-full border rounded p-2 text-sm" placeholder="Ej: Emanuel Cortes Ochoa o Dr. Sergio Angel">
      @error('name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
      <label class="block text-xs font-medium mb-1">Email</label>
      <input type="email" wire:model.defer="email" class="w-full border rounded p-2 text-sm" placeholder="Ej: example@drkiwimed.com">
      @error('email') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block text-xs font-medium mb-1">Contraseña {{ $isEdit ? '(deja en blanco si no cambias)' : '' }}</label>
      <input type="password" wire:model.defer="password" class="w-full border rounded p-2 text-sm" autocomplete="new-password">
      @error('password') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block text-xs font-medium mb-1">Confirmar contraseña</label>
      <input type="password" wire:model.defer="password_confirmation" class="w-full border rounded p-2 text-sm" autocomplete="new-password">
    </div>

    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-xs font-medium mb-1">Número de empleado</label>
        <input type="text" wire:model.defer="employee_number" class="w-full border rounded p-2 text-sm" placeholder="120301">
      </div>

      <div>
        <label class="block text-xs font-medium mb-1">Cumpleaños</label>
        <input type="date" wire:model.defer="birthday" class="w-full border rounded p-2 text-sm">
      </div>

      <div>
        <label class="block text-xs font-medium mb-1">Aniversario en Dr. Kiwimed</label>
        <input type="date" wire:model.defer="anniversary_kiwimed" class="w-full border rounded p-2 text-sm">
      </div>

      <div>
        <label class="block text-xs font-medium mb-1">Aniversario Grupo Empresarial</label>
        <input type="date" wire:model.defer="anniversary_group" class="w-full border rounded p-2 text-sm">
      </div>

      <div>
        <label class="block text-xs font-medium mb-1">País</label>
        <select wire:model.defer="country_code" class="w-full border rounded p-2 text-sm">
          <option value="">—</option>
          {{-- agrega los que uses más; ISO-2 minúsculas --}}
          <option value="co">Colombia</option>
          <option value="mx">México</option>
          <option value="cr">Costa Rica</option>
          <option value="pr">Puerto Rico</option>
          <option value="us">Estados Unidos</option>
          <!-- añade los que necesites -->
        </select>
      </div>

      <div>
        <label class="block text-xs font-medium mb-1">Número Spruce (opcional)</label>
        <input type="text" wire:model.defer="spruce_number" class="w-full border rounded p-2 text-sm" placeholder="+1 (###) ###-####">
      </div>

      <div>
        <label class="block text-xs font-medium mb-1">Número Crecer (opcional)</label>
        <input type="text" wire:model.defer="crecer_number" class="w-full border rounded p-2 text-sm" placeholder="+1 (###) ###-####">
      </div>

      
      <div class="flex items-center gap-2 mt-6 md:mt-0">
        <input type="checkbox" wire:model.defer="has_id_badge" class="rounded border-gray-300">
        <label class="text-sm">Tiene ID Badge</label>
      </div>
    </div>

    {{-- Roles --}}
    <div>
      <label class="block text-xs font-medium mb-1">Roles</label>
      <div class="border rounded p-2 max-h-40 overflow-auto space-y-1">
        @forelse($allRoles as $r)
          <label class="flex items-center gap-2 text-sm">
            {{-- al cambiar, Livewire llamará updatedRoles() --}}
            <input type="checkbox" value="{{ $r }}" wire:model="roles" class="rounded border-gray-300">
            <span>{{ $r }}</span>
          </label>
        @empty
          <div class="text-xs text-gray-500">No hay roles creados.</div>
        @endforelse
      </div>
    </div>

    {{-- Permisos heredados por rol (solo lectura) --}}
    <div>
      <label class="block text-xs font-medium mb-1">Permisos heredados por rol</label>
      <div class="border rounded p-2 max-h-40 overflow-auto space-y-1 bg-neutral-50">
        @forelse($inheritedOptions as $op)
          <div class="flex items-center gap-2 text-sm opacity-75">
            <input type="checkbox" checked disabled class="rounded border-gray-300">
            <span>{{ $op['label'] }}</span>
            <span class="text-[10px] uppercase px-1.5 py-0.5 rounded bg-gray-200 text-gray-700">heredado</span>
          </div>
        @empty
          <div class="text-xs text-gray-500">Ninguno</div>
        @endforelse
      </div>
      <p class="mt-1 text-[11px] text-gray-500">Estos permisos vienen de los roles seleccionados.</p>
    </div>

    {{-- Permisos directos (no incluye los heredados) --}}
    <div class="md:col-span-2">
      <label class="block text-xs font-medium mb-1">Permisos directos</label>
      <div class="border rounded p-2 max-h-56 overflow-auto grid grid-cols-1 md:grid-cols-2 gap-1">
        @forelse($permOptions as $op)
          <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" value="{{ $op['name'] }}" wire:model="permissions" class="rounded border-gray-300">
            <span>{{ $op['label'] }}</span>
          </label>
        @empty
          <div class="text-xs text-gray-500">No hay permisos creados.</div>
        @endforelse
      </div>
      @error('permissions.*') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>


    <div class="md:col-span-2 flex items-center gap-3 mt-5 justify-end">
      <button type="submit" class="flex items-center cursor-pointer px-3 py-2 text-neutral-50 rounded-lg group hover:shadow shadow-[#31353d] dark:shadow-[#4a4e58] bg-gradient-to-t active:bg-gradient-to-b from-[#6fa31c] to-[#123338] transition ease-in-out duration-300 text-sm hover:scale-105 font-semibold">
        {{ $isEdit ? 'Guardar cambios' : 'Crear usuario' }}
      </button>
      <a href="{{ $redirect ?? route('users.index') }}" class="px-4 py-2 rounded-lg bg-gray-900 text-white transition ease-in-out duration-300 text-sm hover:scale-105 font-semibold">Cancelar</a>
    </div>
  </form>
</div>
