<div class="p-6 space-y-6">
  <div class="flex items-center justify-between gap-3">
    <h1 class="text-xl font-semibold">Doctores</h1>
    @can('create', \App\Models\Doctor::class)
      <a href="{{ route('doctors.create') }}" class="px-3 py-2 rounded bg-gray-900 text-white text-sm">
        Nuevo doctor
      </a>
    @endcan
  </div>

  @if (session('ok'))
    <div class="p-3 rounded bg-green-100 text-green-800 text-sm">{{ session('ok') }}</div>
  @endif

  <div class="flex items-center justify-between">
    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar por nombre, email o especialidad…" class="w-72 border rounded p-2 text-sm">
    <span class="text-xs text-gray-500">Resultados: {{ $doctors->total() }}</span>
  </div>

  <div class="overflow-auto rounded border">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-50 text-left">
        <tr>
          <th class="p-2">Nombre</th>
          <th class="p-2">Email</th>
          <th class="p-2">Especialidad</th>
          <th class="p-2 w-32 text-right">Acciones</th>
        </tr>
      </thead>
      <tbody class="divide-y">
        @forelse($doctors as $d)
          <tr class="hover:bg-gray-50">
            <td class="p-2 whitespace-nowrap">{{ $d->user?->name ?? '—' }}</td>
            <td class="p-2 whitespace-nowrap">{{ $d->user?->email ?? '—' }}</td>
            <td class="p-2">{{ $d->specialty ?? '—' }}</td>
            <td class="p-2 text-right space-x-2">
              <a href="{{ route('doctors.edit', $d) }}" class="text-blue-600 hover:underline text-xs">Editar</a>

              @can('delete', $d)
              <button
                x-data
                @click.prevent="if (confirm('Eliminar este doctor?')) { $wire.delete({{ $d->id }}) }"
                class="text-rose-600 hover:underline text-xs"
                type="button"
              >
                Eliminar
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
