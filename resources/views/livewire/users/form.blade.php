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
      <input type="text" wire:model.defer="name" class="w-full border rounded p-2 text-sm">
      @error('name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
      <label class="block text-xs font-medium mb-1">Email</label>
      <input type="email" wire:model.defer="email" class="w-full border rounded p-2 text-sm">
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

    <div class="md:col-span-2 flex items-center gap-2 mt-2">
      <input id="email_verified" type="checkbox" wire:model="email_verified" class="rounded border-gray-300">
      <label for="email_verified" class="text-sm">Email verificado</label>
    </div>

    <div>
      <label class="block text-xs font-medium mb-1">Roles</label>
      <div class="border rounded p-2 max-h-40 overflow-auto space-y-1">
        @foreach($allRoles as $r)
          <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" value="{{ $r }}" wire:model="roles" class="rounded border-gray-300">
            <span>{{ $r }}</span>
          </label>
        @endforeach
      </div>
      @error('roles.*') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
    <label class="block text-xs font-medium mb-1">Permisos</label>

    @if (empty($allPerms))
        <div class="p-3 rounded border text-sm bg-amber-50 border-amber-200 text-amber-900">
        No hay permisos creados. Crea permisos con Spatie antes de asignarlos.
        <div class="mt-2 text-xs">
            Tip: ejecuta <code>php artisan db:seed --class=PermissionsSeeder</code> y luego
            <code>php artisan permission:cache-reset</code>.
        </div>
        </div>
    @else
        <div class="border rounded p-2 max-h-40 overflow-auto space-y-1">
        @foreach($allPerms as $p)
            <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" value="{{ $p }}" wire:model="permissions" class="rounded border-gray-300">
            <span>{{ $p }}</span>
            </label>
        @endforeach
        </div>
    @endif

    @error('permissions.*') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
    </div>


    <div class="md:col-span-2 flex items-center gap-3">
      <button type="submit" class="px-4 py-2 rounded bg-gray-900 text-white text-sm">
        {{ $isEdit ? 'Guardar cambios' : 'Crear usuario' }}
      </button>
      <a href="{{ $redirect ?? route('users.index') }}" class="text-sm underline">Cancelar</a>
    </div>
  </form>
</div>
