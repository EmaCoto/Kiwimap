<div class="p-6 space-y-6">
  <div class="flex items-center justify-between gap-3">
    <h1 class="text-xl font-semibold">Licencias</h1>
    @can('create', \App\Models\License::class)
      <a href="{{ route('licenses.create') }}" class="px-3 py-2 rounded bg-gray-900 text-white text-sm">
        Nueva licencia
      </a>
    @endcan
  </div>

  @if (session('ok'))
    <div class="p-3 rounded bg-green-100 text-green-800 text-sm">{{ session('ok') }}</div>
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
    <button wire:click="clearFilters" class="text-xs underline">Limpiar filtros</button>
    <span class="text-xs text-gray-500">Resultados: {{ $licenses->total() }}</span>
  </div>

  <div class="overflow-auto rounded border">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-50 text-left">
        <tr>
          <th class="p-2">Doctor</th>
          <th class="p-2">Estado</th>
          <th class="p-2">Emitida</th>
          <th class="p-2">Expira</th>
          <th class="p-2">Status</th>
          <th class="p-2">Link</th>
          <th class="p-2 w-32 text-right">Acciones</th>
        </tr>
      </thead>
      <tbody class="divide-y">
        @forelse($licenses as $l)
          <tr class="hover:bg-gray-50">
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
            <td class="p-2 text-right space-x-2">
              <a href="{{ route('licenses.edit', $l) }}" class="text-blue-600 hover:underline text-xs">Editar</a>

              @can('delete', $l)
              <button
                x-data
                @click.prevent="if (confirm('Eliminar esta licencia?')) { $wire.delete({{ $l->id }}) }"
                type="button"
                class="text-rose-600 hover:underline text-xs"
              >
                Eliminar
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
