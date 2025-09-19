<div class="p-6 space-y-6">
  <div class="flex items-center justify-between gap-3">
    <h1 class="text-xl font-semibold">Doctores</h1>
    @can('create', \App\Models\Doctor::class)
      <a href="{{ route('doctors.create') }}" class="flex items-center px-3 py-2 text-neutral-50 rounded-lg group hover:shadow shadow-[#31353d] dark:shadow-[#4a4e58] bg-gradient-to-t active:bg-gradient-to-b from-[#6fa31c] to-[#123338] transition ease-in-out duration-300 text-sm hover:scale-105  font-semibold">
        <flux:icon name="user-plus" class="h-4 w-4 mr-2" />Agregar doctor
      </a>
    @endcan
  </div>

  @if (session('ok'))
    <div class="p-3 rounded border-l-2 border-green-800 bg-green-100 text-green-800 text-sm flex items-center"><flux:icon name="bell" class="h-4 w-4 mr-4" />{{ session('ok') }}</div>
  @endif

  <div class="flex items-center justify-between">
    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar por nombre, email o especialidad…" class="w-72 border rounded p-2 text-sm">
    <span class="text-xs text-gray-500">Resultados: {{ $doctors->total() }}</span>
  </div>

  <div class="overflow-auto rounded border">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-100 dark:text-black text-left">
        <tr>
          <th class="p-2">Nombre</th>
          <th class="p-2">Email</th>
          <th class="p-2">Especialidad</th>
          <th class="p-2 w-32">Acciones</th>
        </tr>
      </thead>
      <tbody class="divide-y">
        @forelse($doctors as $d)
          <tr class="hover:bg-gray-100 dark:hover:text-black">
            <td class="p-2 whitespace-nowrap">{{ $d->user?->name ?? '—' }}</td>
            <td class="p-2 whitespace-nowrap">{{ $d->user?->email ?? '—' }}</td>
            <td class="p-2">{{ $d->specialty ?? '—' }}</td>
            <td class="p-2 space-x-2 flex">
              <a href="{{ route('doctors.edit', $d) }}" class="text-blue-600 hover:underline text-xs"><flux:icon name="pencil-square" class="h-4 w-4" /></a>

              @can('delete', $d)
              <button
                x-data
                @click.prevent="if (confirm('¿Seguro que quieres eliminar este doctor?')) { $wire.delete({{ $d->id }}) }"
                class="text-rose-600 hover:underline text-xs cursor-pointer"
                type="button"
              >
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

  <div>
    {{ $doctors->links() }}
  </div>
</div>
