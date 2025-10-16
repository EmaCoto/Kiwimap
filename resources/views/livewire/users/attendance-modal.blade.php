<div x-data x-show="$wire.open" x-cloak class="fixed inset-0 z-50 flex items-start justify-center bg-black/30">
  <div class="mt-6 w-[900px] rounded-lg bg-white p-5 shadow">
    <div class="flex items-center justify-between mb-3">
      <h2 class="font-semibold">Asistencia — {{ $user?->name }}</h2>
      <button class="text-sm underline" wire:click="close">Cerrar</button>
    </div>

    <p class="text-sm text-gray-600 mb-4">
      TZ: {{ $tzLabel }} —
      Hoy: {{ $todayStr }} —
      Estado: {{ $rows[0]['status'] ?? '—' }}
    </p>

    <div class="grid grid-cols-3 gap-3 mb-4">
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
    </div>

    <div class="overflow-auto rounded border">
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
  </div>
</div>
