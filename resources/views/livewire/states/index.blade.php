<div class="p-6 space-y-6">
  <div class="flex items-center justify-between gap-3">
    <h1 class="text-xl font-semibold">Estados</h1>
    @can('create', \App\Models\State::class)
      <a href="{{ route('states.create') }}" class="flex items-center px-3 py-2 text-neutral-50 rounded-lg group hover:shadow shadow-[#31353d] dark:shadow-[#4a4e58] bg-gradient-to-t active:bg-gradient-to-b from-[#6fa31c] to-[#123338] transition ease-in-out duration-300 text-sm hover:scale-105  font-semibold">
        <flux:icon name="globe-americas" class="h-4 w-4 mr-2" />Agregar estado
      </a>
    @endcan
  </div>

  @if (session('ok'))
    <div class="p-3 rounded border-l-2 border-green-800 bg-green-100 text-green-800 text-sm flex items-center"><flux:icon name="bell" class="h-4 w-4 mr-4" />{{ session('ok') }}</div>
  @endif

  <div class="grid grid-cols-1 md:grid-cols-3 gap-3 items-end">
    <div class="md:col-span-2">
      <label class="block text-xs font-medium mb-1">Búsqueda</label>
      <input type="text" wire:model.live.debounce.300ms="search" placeholder="Nombre o código…" class="w-full border rounded p-2 text-sm">
    </div>

    <div>
      <label class="block text-xs font-medium mb-1">Operacional</label>
      <select wire:model.live="operational" class="w-full border rounded p-2 text-sm">
        <option value="all">Todos</option>
        <option value="yes">Sí</option>
        <option value="no">No</option>
      </select>
    </div>
  </div>

  <div class="overflow-auto rounded border">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-100 text-left dark:text-black">
        <tr>
          <th class="p-2">Nombre</th>
          <th class="p-2">Código</th>
          <th class="p-2">Operacional</th>
          <th class="p-2 w-32">Acciones</th>
        </tr>
      </thead>
      <tbody class="divide-y">
        @forelse($states as $s)
          <tr class="hover:bg-gray-100 dark:hover:text-black">
            <td class="p-2 whitespace-nowrap">{{ $s->name }}</td>
            <td class="p-2 whitespace-nowrap">{{ $s->code }}</td>
            <td class="p-2">
              @if($s->is_operational)
                <span class="px-2 py-0.5 rounded text-xs bg-emerald-100 text-emerald-800">Sí</span>
              @else
                <span class="px-2 py-0.5 rounded text-xs bg-gray-100 text-gray-800">No</span>
              @endif
            </td>
            <td class="p-2 space-x-2 flex">
              <a href="{{ route('states.edit', $s) }}" class="text-blue-600 hover:underline text-xs"><flux:icon name="pencil-square" class="h-4 w-4" /></a>

              @can('delete', $s)
              <button
                x-data
                @click.prevent="if (confirm('Eliminar este estado?')) { $wire.delete({{ $s->id }}) }"
                type="button"
                class="text-rose-600 hover:underline text-xs"
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
    {{ $states->links() }}
  </div>
</div>
