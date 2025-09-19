<div class="p-6 space-y-6">
  <div class="flex items-center justify-between gap-3">
    <h1 class="text-xl font-semibold">Licencias</h1>
    @can('create', \App\Models\License::class)
      <a href="{{ route('licenses.create') }}" class="flex items-center px-3 py-2 text-neutral-50 rounded-lg group hover:shadow shadow-[#31353d] dark:shadow-[#4a4e58] bg-gradient-to-t active:bg-gradient-to-b from-[#6fa31c] to-[#123338] transition ease-in-out duration-300 text-sm hover:scale-105  font-semibold">
        <flux:icon name="folder-plus" class="h-4 w-4 mr-2" />Agregar licencia
      </a>
    @endcan
  </div>

  @if (session('ok'))
    <div class="p-3 rounded border-l-2 border-green-800 bg-green-100 text-green-800 text-sm flex items-center"><flux:icon name="bell" class="h-4 w-4 mr-4" />{{ session('ok') }}</div>
  @endif

  <div class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">
    <div>
      <label class="block text-xs font-medium mb-1">Estado</label>
      <select wire:model.live="stateCode" class="w-full border rounded p-2 text-sm">
        <option value="">Todos</option>
        @foreach($states as $s)
          <option value="{{ $s->code }}">{{ $s->name }} ({{ $s->code }})</option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-xs font-medium mb-1">Status</label>
      <select wire:model.live="status" class="w-full border rounded p-2 text-sm">
        <option value="all">Todos</option>
        <option value="active">Activa</option>
        <option value="pending">Pendiente</option>
        <option value="expired">Vencida</option>
      </select>
    </div>

    <div class="md:col-span-2">
      <label class="block text-xs font-medium mb-1">Búsqueda</label>
      <input type="text" wire:model.live.debounce.300ms="search" placeholder="Doctor o estado…" class="w-full border rounded p-2 text-sm">
    </div>
  </div>

  <div class="flex justify-between items-center">
    <button wire:click="clearFilters" class="bg-white text-center w-42 rounded-2xl h-14 relative text-black text-sm font-semibold group cursor-pointer" type="button">
      <div class="bg-gradient-to-b active:bg-gradient-to-t from-[#6fa31c] to-[#123338] rounded-lg h-10 w-1/5 flex items-center justify-center absolute left-1 top-[10px] group-hover:w-[150px] z-10 hover:shadow transform duration-500 ease-in-out">
        <flux:icon name="paint-brush" class="h-4 w-4 text-white" />
      </div>
      <p class="translate-x-2">Limpiar filtro</p>
    </button>
    <span class="text-xs text-gray-500">Resultados: {{ $licenses->total() }}</span>
  </div>

  <div class="overflow-auto rounded border">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-100 text-left dark:text-black">
        <tr>
          <th class="p-2">ID</th>
          <th class="p-2">Doctor</th>
          <th class="p-2">Estado</th>
          <th class="p-2">Emitida</th>
          <th class="p-2">Expira</th>
          <th class="p-2">Status</th>
          <th class="p-2">Link</th>
          <th class="p-2 w-32">Acciones</th>
        </tr>
      </thead>
      <tbody class="divide-y">
        @forelse($licenses as $l)
          <tr class="hover:bg-gray-100 dark:hover:text-black">
            <td class="p-2 whitespace-nowrap">{{ $l->id ?? '—' }}</td>
            <td class="p-2 whitespace-nowrap">{{ $l->doctor?->user?->name ?? '—' }}</td>
            <td class="p-2 whitespace-nowrap">{{ $l->state?->name }} ({{ $l->state?->code }})</td>
            <td class="p-2">{{ optional($l->issued_date)->toDateString() ?? '—' }}</td>
            <td class="p-2">{{ optional($l->expiration_date)->toDateString() ?? '—' }}</td>
            <td class="p-2">
              @php
                $badge = [
                  'active' => 'bg-emerald-100 text-emerald-800',
                  'pending'=> 'bg-amber-100 text-amber-800',
                  'expired'=> 'bg-rose-100 text-rose-800'
                ][$l->status] ?? 'bg-gray-100 text-gray-800';
              @endphp
              <span class="px-2 py-0.5 rounded text-xs {{ $badge }}">{{ ucfirst($l->status) }}</span>
            </td>
            <td class="p-2">
              @if($l->has_active_link)
                <span class="px-2 py-0.5 rounded text-xs bg-emerald-100 text-emerald-800">Sí</span>
              @else
                <span class="px-2 py-0.5 rounded text-xs bg-gray-100 text-gray-800">No</span>
              @endif
            </td>
            <td class="p-2 space-x-2 flex">
              <a href="{{ route('licenses.edit', $l) }}" class="text-blue-600 hover:underline text-xs"><flux:icon name="pencil-square" class="h-4 w-4" /></a>

              @can('delete', $l)
              <button
                x-data
                @click.prevent="if (confirm('Eliminar esta licencia?')) { $wire.delete({{ $l->id }}) }"
                type="button"
                class="text-rose-600 hover:underline text-xs"
              >
                <flux:icon name="trash" class="h-4 w-4" />
              </button>
              @endcan
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="p-4 text-center text-gray-500">Sin resultados.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div>
    {{ $licenses->links() }}
  </div>
</div>
