<div x-data x-show="$wire.open" x-cloak class="fixed inset-0 z-50 flex items-start justify-center bg-black/30">
  <div class="mt-6 w-[900px] max-h-[85vh] overflow-y-auto rounded-lg bg-white p-5 shadow">
    <div class="flex items-center justify-between mb-3">
      <h2 class="font-semibold">Asistencia — {{ $user?->name }}</h2>
      <button class="text-sm underline" wire:click="close">Cerrar</button>
    </div>

    <p class="text-sm text-gray-600 mb-4">
      TZ: {{ $tzLabel }} —
      Hoy: {{ $todayStr }} —
      Estado: {{ $rows[0]['status'] ?? '—' }}
    </p>

    <div class="grid grid-cols-4 gap-3 mb-4">
      <div class="rounded border p-3">
        <div class="text-xs text-gray-500">Hoy</div>
        <div class="text-2xl font-semibold">{{ $todayHhMm }}</div>
      </div>
      <div class="rounded border p-3">
        <div class="text-xs text-gray-500">Semana</div>
        <div class="text-2xl font-semibold">{{ $weekHhMm }}</div>
      </div>
      <div class="rounded border p-3">
        <div class="text-xs text-gray-500">Mes</div>
        <div class="text-2xl font-semibold">{{ $monthHhMm }}</div>
      </div>
      <div class="rounded border p-3">
        <div class="text-xs text-gray-500">Año</div>
        <div class="text-2xl font-semibold">{{ $yearHhMm }}</div>
      </div>
    </div>

    {{-- Tabla con paginación --}}
    <div class="rounded border">
      <div class="overflow-auto">
        <table class="min-w-full text-sm">
          <thead class="bg-gray-100 text-left">
            <tr>
              <th class="p-2">Fecha</th>
              <th class="p-2">Entrada</th>
              <th class="p-2">Break 1</th>
              <th class="p-2">Break 2</th>
              <th class="p-2">Lunch</th>
              <th class="p-2">Salida</th>
              <th class="p-2">Trabajado</th>
              <th class="p-2">Estado</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            @forelse($rows as $row)
              <tr>
                <td class="p-2 whitespace-nowrap">{{ $row['date'] }}</td>
                <td class="p-2 whitespace-nowrap">{{ $row['in'] ?? '—' }}</td>
                <td class="p-2 whitespace-nowrap">
                  {{ $row['b1s'] ?? '—' }} @if($row['b1e']) / {{ $row['b1e'] }} @endif
                </td>
                <td class="p-2 whitespace-nowrap">
                  {{ $row['b2s'] ?? '—' }} @if($row['b2e']) / {{ $row['b2e'] }} @endif
                </td>
                <td class="p-2 whitespace-nowrap">
                  {{ $row['ls'] ?? '—' }} @if($row['le']) / {{ $row['le'] }} @endif
                </td>
                <td class="p-2 whitespace-nowrap">{{ $row['out'] ?? '—' }}</td>
                <td class="p-2 font-semibold">{{ $row['worked'] }}</td>
                <td class="p-2 whitespace-nowrap">{{ $row['status'] }}</td>
              </tr>
            @empty
              <tr><td colspan="8" class="p-4 text-center text-gray-500">Sin registros.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Controles de paginación --}}
      <div class="flex items-center justify-between p-2">
        <div class="text-xs text-gray-500">
          @if($paginator)
            Página {{ $paginator->currentPage() }} de {{ $paginator->lastPage() }} — Total: {{ $paginator->total() }}
          @endif
        </div>
        <div class="flex gap-2">
          <button
            wire:click="previous"
            class="px-3 py-1 rounded border text-sm disabled:opacity-50"
            @if(!$paginator || !$paginator->previousPageUrl()) disabled @endif
          >Anterior</button>

          <button
            wire:click="next"
            class="px-3 py-1 rounded border text-sm disabled:opacity-50"
            @if(!$paginator || !$paginator->nextPageUrl()) disabled @endif
          >Siguiente</button>
        </div>
      </div>
    </div>

    {{-- Historial mensual (últimos 12) --}}
    <div class="mt-6">
      <h3 class="font-semibold mb-2">Historial mensual (últimos 12)</h3>
      <div class="overflow-auto rounded border">
        <table class="min-w-full text-sm">
          <thead class="bg-gray-100 text-left">
            <tr>
              <th class="p-2">Mes</th>
              <th class="p-2">Horas trabajadas</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            @forelse($history as $h)
              @php
                // Formato: "23, diciembre de 2004" no aplica a mes; presentamos "Octubre 2025"
                $m = \Illuminate\Support\Carbon::parse($h['month'])->isoFormat('MMMM YYYY');
              @endphp
              <tr>
                <td class="p-2 whitespace-nowrap capitalize">{{ $m }}</td>
                <td class="p-2 font-semibold">{{ $h['hhmm'] }}</td>
              </tr>
            @empty
              <tr><td colspan="2" class="p-4 text-center text-gray-500">Sin historial.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <p class="mt-2 text-xs text-gray-500">
        * Se actualiza automáticamente al cerrar el mes. Si algún mes no existía en resumen, se calcula en tiempo real.
      </p>
    </div>
  </div>
</div>
