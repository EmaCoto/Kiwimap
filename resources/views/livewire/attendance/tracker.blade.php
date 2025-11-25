<div x-data x-init="$wire.setTz(Intl.DateTimeFormat().resolvedOptions().timeZone)" class="space-y-4">
  <h1 class="font-semibold">Marcador de asistencia</h1>
  <p class="text-sm text-gray-600 dark:text-gray-400">
    {{ $today }} — TZ: {{ $tz }}
  </p>

  <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
    <button wire:click="clockIn" @disabled($closed || $a->clock_in) class="px-3 py-2 rounded text-sm flex items-center justify-between border-white border  {{ ($closed || $a->clock_in) ? 'opacity-30 cursor-not-allowed bg-gradient-to-t from-[#6fa31c] to-[#123338] text-white' : 'bg-gradient-to-t from-[#6fa31c] to-[#123338] text-white cursor-pointer' }}">
      <flux:icon name="arrow-right-end-on-rectangle" class="h-4 w-4 mr-1" /> Entrada
      <span></span>
    </button>

    <button wire:click="break1Start" @disabled($closed || $a->break1_start) class="px-3 py-2 rounded text-sm border border-black flex items-center justify-between dark:border-white  {{ ($closed || $a->break1_start) ? 'opacity-30 cursor-not-allowed' : 'cursor-pointer hover:skew-3' }}">
      <flux:icon name="clock" class="h-4 w-4 mr-1" /> Break 1 — Inicio (COL - CR)
      <span></span>
    </button>

    <button wire:click="break2Start" @disabled($closed || $a->break2_start) class="px-3 py-2 rounded text-sm border border-black flex items-center justify-between dark:border-white  {{ ($closed || $a->break2_start) ? 'opacity-30 cursor-not-allowed' : 'cursor-pointer hover:skew-3' }}">
      <flux:icon name="clock" class="h-4 w-4 mr-1" /> Break 2 — Inicio (COL - CR)
      <span></span>
    </button>

    <button wire:click="lunchStart" @disabled($closed || $a->lunch_start) class="px-3 py-2 rounded text-sm border border-black flex items-center justify-between dark:border-white  {{ ($closed || $a->lunch_start) ? 'opacity-30 cursor-not-allowed' : 'cursor-pointer hover:skew-3' }}">
      <flux:icon name="pause-circle" class="h-4 w-4 mr-1" />Lunch — Inicio
      <span></span>
    </button>

    <button wire:click="clockOut" @disabled($closed || !$a->clock_in || $a->clock_out) class="px-3 py-2 rounded text-sm flex items-center justify-between dark:border-white border {{ ($closed || !$a->clock_in || $a->clock_out) ? 'opacity-30 cursor-not-allowed bg-gradient-to-t from-[#351d5b] to-[#31353d] text-white' : 'bg-gradient-to-t from-[#351d5b] to-[#31353d] text-white cursor-pointer' }}">
      <flux:icon name="arrow-right-start-on-rectangle" class="h-4 w-4 mr-1" />Salida
      <span></span>
    </button>

    <button wire:click="break1End" @disabled($closed || !$a->break1_start || $a->break1_end) class="px-3 py-2 rounded text-sm border border-black flex items-center justify-between dark:border-white  {{ ($closed || !$a->break1_start || $a->break1_end) ? 'opacity-30 cursor-not-allowed' : 'cursor-pointer hover:skew-3' }}">
      <flux:icon name="clock" class="h-4 w-4 mr-1" /> Break 1 — Fin
      <span></span>
    </button>

    <button wire:click="break2End" @disabled($closed || !$a->break2_start || $a->break2_end) class="px-3 py-2 rounded text-sm border border-black flex items-center justify-between dark:border-white  {{ ($closed || !$a->break2_start || $a->break2_end) ? 'opacity-30 cursor-not-allowed' : 'cursor-pointer hover:skew-3' }}">
      <flux:icon name="clock" class="h-4 w-4 mr-1" /> Break 2 — Fin
      <span></span>
    </button>

    <button wire:click="lunchEnd" @disabled($closed || !$a->lunch_start || $a->lunch_end) class="px-3 py-2 rounded text-sm border border-black flex items-center justify-between dark:border-white  {{ ($closed || !$a->lunch_start || $a->lunch_end) ? 'opacity-30 cursor-not-allowed' : 'cursor-pointer hover:skew-3' }}">
      <flux:icon name="play-circle" class="h-4 w-4 mr-1" /> Lunch — Fin
      <span></span>
    </button>

  </div>

  <hr class="w-full my-10">

  <div class="text-md space-y-5">
    <h2 class="font-semibold text-center">Conteo de horas del día</h2>
    @php
      $get = fn($col) => $a->getRawTime($col)?->format('H:i:s') ?? '—';
    @endphp


    <div class="grid grid-cols-4 gap-8 justify-center items-center text-center">

      <!-- Entrada / Salida -->
      <div class="flex h-[5em] w-[14em] items-center justify-center rounded-md mx-auto">
        <div class="group relative flex h-[3em] w-[3em] items-center justify-center rounded-md border-[1px] border-[#ffffffaa] bg-gradient-to-t from-[#6fa31c] to-[#123338] duration-[500ms] hover:h-[5em] hover:w-[14em] shadow mx-auto">
          <flux:icon name="home-modern" class="absolute h-[1.5em] w-[1.5em] duration-300 group-hover:opacity-0 text-white" />
          <div class="duration-600 flex h-[5em] w-[16em] flex-col justify-center p-2 text-white mx-auto">
            <div class="flex flex-col justify-center opacity-0 group-hover:opacity-100 hover:duration-[3500ms] text-left">
              <p><strong>Entrada:</strong> {{ $get('clock_in') }}</p>
              <p><strong>Salida:</strong> {{ $get('clock_out') }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Break 1 -->
      <div class="flex h-[5em] w-[14em] items-center justify-center rounded-md mx-auto">
        <div class="group relative flex h-[3em] w-[3em] items-center justify-center rounded-md border-[1px] border-[#ffffffaa] bg-gradient-to-t from-[#6fa31c] to-[#123338] duration-[500ms] hover:h-[5em] hover:w-[14em] shadow mx-auto">
          <flux:icon name="clock" class="absolute h-[1.5em] w-[1.5em] duration-300 group-hover:opacity-0 text-white" />
          <div class="duration-600 flex h-[5em] w-[16em] flex-col justify-center p-2 text-white mx-auto">
            <div class="flex flex-col justify-center opacity-0 group-hover:opacity-100 hover:duration-[3500ms] text-left">
              <p><strong>Break 1 — Inicio:</strong> {{ $get('break1_start') }}</p>
              <p><strong>Break 1 — Fin:</strong> {{ $get('break1_end') }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Break 2 -->
      <div class="flex h-[5em] w-[14em] items-center justify-center rounded-md mx-auto">
        <div class="group relative flex h-[3em] w-[3em] items-center justify-center rounded-md border-[1px] border-[#ffffffaa] bg-gradient-to-t from-[#6fa31c] to-[#123338] duration-[500ms] hover:h-[5em] hover:w-[14em] shadow mx-auto">
          <flux:icon name="clock" class="absolute h-[1.5em] w-[1.5em] duration-300 group-hover:opacity-0 text-white" />
          <div class="duration-600 flex h-[5em] w-[16em] flex-col justify-center p-2 text-white mx-auto">
            <div class="flex flex-col justify-center opacity-0 group-hover:opacity-100 hover:duration-[3500ms] text-left">
              <p><strong>Break 2 — Inicio:</strong> {{ $get('break2_start') }}</p>
              <p><strong>Break 2 — Fin:</strong> {{ $get('break2_end') }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Lunch -->
      <div class="flex h-[5em] w-[14em] items-center justify-center rounded-md mx-auto">
        <div class="group relative flex h-[3em] w-[3em] items-center justify-center rounded-md border-[1px] border-[#ffffffaa] bg-gradient-to-t from-[#6fa31c] to-[#123338] duration-[500ms] hover:h-[5em] hover:w-[14em] shadow mx-auto">
          <flux:icon name="pause-circle" class="absolute h-[1.5em] w-[1.5em] duration-300 group-hover:opacity-0 text-white" />
          <div class="duration-600 flex h-[5em] w-[16em] flex-col justify-center p-2 text-white mx-auto">
            <div class="flex flex-col justify-center opacity-0 group-hover:opacity-100 hover:duration-[3500ms] text-left">
              <p><strong>Lunch — Inicio:</strong> {{ $get('lunch_start') }}</p>
              <p><strong>Lunch — Fin:</strong> {{ $get('lunch_end') }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Estado -->
      <div class="flex-col border p-4 text-center rounded-md w-40 shadow-lg mx-auto col-span-2">
        <p class="font-bold border-b">Estado</p>
        <p>
          {{ [
            'offline'=>'Offline',
            'working'=>'Working',
            'break1'=>'Break 1',
            'break2'=>'Break 2',
            'lunch'=>'Lunch',
            'clocked_out'=>'Clocked out'
          ][$status] ?? $status }}
        </p>
      </div>

      <!-- Horas de hoy -->
      <div class="flex-col border p-4 text-center rounded-md w-40 shadow-lg mx-auto col-span-2">
        <p class="font-bold border-b">Horas de hoy</p>
        <p>{{ $todayHHMM }}</p>
      </div>

    </div>
    
  </div>
</div>
