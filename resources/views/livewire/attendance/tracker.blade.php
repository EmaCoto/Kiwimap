<div x-data x-init="$wire.setTz(Intl.DateTimeFormat().resolvedOptions().timeZone)" class="space-y-4">
  <h1 class="font-semibold">Marcador de asistencia</h1>
  <p class="text-sm text-gray-600">
    {{ $today }} — TZ: {{ $tz }}
  </p>

  <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
    <button
      wire:click="clockIn"
      @disabled($closed || $a->clock_in)
      class="px-3 py-2 rounded text-sm flex items-center justify-center {{ ($closed || $a->clock_in) ? 'opacity-50 cursor-not-allowed bg-gradient-to-t from-[#6fa31c] to-[#123338] text-white' : 'bg-gradient-to-t from-[#6fa31c] to-[#123338] text-white cursor-pointer' }}">
      <flux:icon name="arrow-right-end-on-rectangle" class="h-4 w-4 mr-1" /> Entrada
    </button>

    <button
      wire:click="break1Start"
      @disabled($closed || $a->break1_start)
      class="px-3 py-2 rounded text-sm border border-black {{ ($closed || $a->break1_start) ? 'opacity-50 cursor-not-allowed bg-gray-600 text-white' : 'cursor-pointer hover:skew-3' }}">
      Break 1 — Inicio (COL - CR)
    </button>

    <button
      wire:click="break2Start"
      @disabled($closed || $a->break2_start)
      class="px-3 py-2 rounded text-sm border border-black {{ ($closed || $a->break2_start) ? 'opacity-50 cursor-not-allowed bg-gray-600 text-white' : 'cursor-pointer hover:skew-3' }}">
      Break 2 — Inicio (COL - CR)
    </button>

    <button
      wire:click="lunchStart"
      @disabled($closed || $a->lunch_start)
      class="px-3 py-2 rounded text-sm border border-black {{ ($closed || $a->lunch_start) ? 'opacity-50 cursor-not-allowed bg-gray-600 text-white' : 'cursor-pointer hover:skew-3' }}">
      Lunch — Inicio
    </button>

    <button
      wire:click="clockOut"
      @disabled($closed || !$a->clock_in || $a->clock_out)
      class="px-3 py-2 rounded text-sm flex items-center justify-center {{ ($closed || !$a->clock_in || $a->clock_out) ? 'opacity-50 cursor-not-allowed bg-gradient-to-t from-[#351d5b] to-[#31353d] text-white' : 'bg-gradient-to-t from-[#351d5b] to-[#31353d] text-white cursor-pointer' }}">
      <flux:icon name="arrow-right-start-on-rectangle" class="h-4 w-4 mr-1" />Salida
    </button>

    <button
      wire:click="break1End"
      @disabled($closed || !$a->break1_start || $a->break1_end)
      class="px-3 py-2 rounded text-sm border border-black {{ ($closed || !$a->break1_start || $a->break1_end) ? 'opacity-50 cursor-not-allowed bg-gray-600 text-white' : 'cursor-pointer hover:skew-3' }}">
      Break 1 — Fin
    </button>

    <button
      wire:click="break2End"
      @disabled($closed || !$a->break2_start || $a->break2_end)
      class="px-3 py-2 rounded text-sm border border-black {{ ($closed || !$a->break2_start || $a->break2_end) ? 'opacity-50 cursor-not-allowed bg-gray-600 text-white' : 'cursor-pointer hover:skew-3' }}">
      Break 2 — Fin
    </button>

    <button
      wire:click="lunchEnd"
      @disabled($closed || !$a->lunch_start || $a->lunch_end)
      class="px-3 py-2 rounded text-sm border border-black {{ ($closed || !$a->lunch_start || $a->lunch_end) ? 'opacity-50 cursor-not-allowed bg-gray-600 text-white' : 'cursor-pointer hover:skew-3' }}">
      Lunch — Fin
    </button>

  </div>

  <div class="text-md space-y-10 pt-24">
    <h2 class="font-semibold text-center">Conteo de horas del día</h2>
    @php
      $get = fn($col) => $a->getRawTime($col)?->format('H:i:s') ?? '—';
    @endphp

    <div class="grid grid-cols-5 gap-10">
      <div><strong>Entrada:</strong> {{ $get('clock_in') }}</div>
      <div><strong>Break 1:</strong> {{ $get('break1_start') }} — {{ $get('break1_end') }}</div>
      <div><strong>Break 2:</strong> {{ $get('break2_start') }} — {{ $get('break2_end') }}</div>
      <div><strong>Lunch:</strong> {{ $get('lunch_start') }} — {{ $get('lunch_end') }}</div>
      <div><strong>Salida:</strong> {{ $get('clock_out') }}</div>
    </div>
    
    <div class="flex justify-around">
        <div><strong>Estado:</strong>
              {{ [
                'offline'=>'Offline',
                'working'=>'Working',
                'break1'=>'Break 1',
                'break2'=>'Break 2',
                'lunch'=>'Lunch',
                'clocked_out'=>'Clocked out'
              ][$status] ?? $status }}
        </div>
        <div><strong>Horas de hoy:</strong>{{ $todayHHMM }} (HH:MM)</div>
    </div>
  </div>
</div>
