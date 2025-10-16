<div class="p-6 space-y-6">
  <div class="flex items-center justify-between gap-3">
    <h1 class="text-xl font-semibold">Usuarios</h1>
    @can('create', \App\Models\User::class)
      <a href="{{ route('users.create') }}" class="flex items-center px-3 py-2 text-neutral-50 rounded-lg group hover:shadow shadow-[#31353d] dark:shadow-[#4a4e58] bg-gradient-to-t active:bg-gradient-to-b from-[#6fa31c] to-[#123338] transition ease-in-out duration-300 text-sm hover:scale-105  font-semibold">
        <flux:icon name="user-plus" class="h-4 w-4 mr-2" />Agregar usuario
      </a>
    @endcan
  </div>

  @if (session('ok'))
    <div class="p-3 rounded border-l-2 border-green-800 bg-green-100 text-green-800 text-sm flex items-center"><flux:icon name="bell" class="h-4 w-4 mr-4" />{{ session('ok') }}</div>
  @endif
  @if (session('error'))
    <div class="p-3 rounded border-l-2 border-rose-800 bg-rose-100 text-rose-800 text-sm flex items-center"><flux:icon name="bell" class="h-4 w-4 mr-4" />{{ session('error') }}</div>
  @endif

  <div class="flex items-end justify-between gap-3">
    <div class="w-full md:w-1/3">
      <label class="block text-xs font-medium mb-1">Buscar</label>
      <input type="text" wire:model.live.debounce.300ms="search" placeholder="Nombre, email o rol…" class="w-full border rounded p-2 text-sm">
    </div>
    <div class="text-xs text-gray-500">
      Total: {{ $users->total() }}
    </div>
  </div>

  <div class="overflow-auto rounded border">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-100 text-left dark:text-black">
        <tr>
          <th class="p-2">Nombre</th>
          <th class="p-2">Email</th>
          <th class="p-2">Roles</th>
          <th class="p-2 w-36">Acciones</th>
        </tr>
      </thead>
      <tbody class="divide-y">
        @forelse($users as $u)
          <tr class="hover:bg-gray-100 dark:hover:text-black">
            <td class="p-2 whitespace-nowrap">
              <button
                type="button"
                wire:click="$dispatch('open-attendance', { userId: {{ $u->id }} })"
                class="hover:cursor-pointer hover:text-[#4b4a4a] font-medium">
                {{ $u->name }}
              </button>
            </td>
            <td class="p-2">{{ $u->email }}</td>
            <td class="p-2 whitespace-nowrap">
              @if($u->roles->isEmpty())
                <span class="text-xs text-gray-500">—</span>
              @else
                <span class="text-xs">{{ $u->roles->pluck('name')->implode(', ') }}</span>
              @endif
            </td>
            <td class="p-2 space-x-2 flex">
              @can('update', $u)
                <a href="{{ route('users.edit', $u) }}" class="text-blue-600 hover:underline text-xs"><flux:icon name="pencil-square" class="h-4 w-4" /></a>
              @endcan

              @can('delete', $u)
                <button
                  x-data
                  @click.prevent="if (confirm('¿Eliminar este usuario?')) { $wire.delete({{ $u->id }}) }"
                  type="button"
                  class="text-rose-600 hover:underline text-xs cursor-pointer">
                  <flux:icon name="trash" class="h-4 w-4" />
                </button>
              @endcan
            </td>
          </tr>
        @empty
          <tr><td colspan="4" class="p-4 text-center text-gray-500">Sin resultados.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <livewire:users.attendance-modal :key="'users-attendance-modal'" />
  <div>
    {{ $users->links() }}
  </div>
</div>
