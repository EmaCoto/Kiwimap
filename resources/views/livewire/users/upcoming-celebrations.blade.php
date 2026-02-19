<div class="max-w-6xl mx-auto p-6 space-y-10">
  {{-- Encabezado + filtros --}}
  <div class="flex flex-wrap items-end gap-3 px-2">
    <div class="space-y-1">
        <h1 class="text-3xl font-black text-[#123338] dark:text-white tracking-tighter uppercase italic">Próximos Cumpleaniversario</h1>
        <div class="h-1 w-20 bg-[#6fa31c]"></div>
    </div>

    <div class="ms-auto flex items-center gap-4">
      {{-- Filtro de mes --}}
      <div class="flex flex-col">
        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 ml-1">Mes</label>
        <select wire:model.live="month" class="border border-gray-200 dark:border-white/10 bg-white dark:bg-[#123338] rounded-lg p-2 text-[11px] font-bold uppercase tracking-tight focus:ring-1 focus:ring-[#6fa31c] outline-none">
          <option value="" class="dark:text-black">Mes actual</option>
          @foreach($monthNames as $num => $name)
            <option value="{{ $num }}" class="dark:text-black">{{ $name }}</option>
          @endforeach
        </select>
      </div>

      {{-- Filtro de tipo --}}
      <div class="flex flex-col">
        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 ml-1">Tipo</label>
        <select wire:model.live="type" class="border border-gray-200 dark:border-white/10 bg-white dark:bg-[#123338] rounded-lg p-2 text-[11px] font-bold uppercase tracking-tight focus:ring-1 focus:ring-[#6fa31c] outline-none">
          <option value="all" class="dark:text-black">Todos</option>
          <option value="birthday" class="dark:text-black">Cumpleaños</option>
          <option value="kiwimed" class="dark:text-black">Aniversario Dr. Kiwimed</option>
          <option value="group" class="dark:text-black">Aniversario Grupo</option>
        </select>
      </div>

      {{-- Limpiar filtros --}}
      <div class="self-end">
        <button wire:click="clearFilters" type="button" class="px-5 py-2.5 rounded-lg bg-gradient-to-t from-[#123338] to-[#1a444a] text-white text-[10px] font-black uppercase tracking-[0.2em] shadow-lg hover:scale-105 transition-all active:scale-95">Limpiar filtros</button>
      </div>
    </div>
    <hr class="w-full border-gray-100 dark:border-white/5 mt-4">
  </div>

  {{-- Sección fija: Mes ACTUAL --}}
  <div class="space-y-4">
    <h2 class="text-[11px] font-black text-[#02a676] uppercase tracking-[0.4em] px-2 italic">Cumpleaniversarios de {{ $monthNames[$currentMonthNum] }}</h2>

    @if(empty($upcomingCurrentMonth))
      <div class="mx-2 p-8 rounded-2xl border-2 border-dashed border-gray-100 dark:border-white/5 text-gray-400 text-[10px] font-black uppercase tracking-widest text-center">
        No hay próximos hitos para el resto del mes.
      </div>
    @else
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($upcomingCurrentMonth as $row)
          @php
            $u      = $row['user'];
            $which  = \App\Models\User::humanMilestoneLabel($row['which']);
            $fecha  = $row['date']->isoFormat('D [de] MMMM YYYY');
            $flag   = $u->country_flag_url ?? null;
            $avatar = $u->avatar_url ?: 'https://ui-avatars.com/api/?name='.urlencode($u->name).'&background=123338&color=ffffff';
            $rol    = method_exists($u, 'primaryRoleName') ? $u->primaryRoleName() : null;
          @endphp

          <div class="group relative bg-white dark:bg-[#123338]/20 border border-gray-100 dark:border-white/5 rounded-2xl p-4 transition-all hover:shadow-2xl hover:shadow-[#123338]/10 hover:-translate-y-1 overflow-hidden">
            <img src="{{ asset('img/ballons.gif') }}" alt="" class="absolute -right-4 -top-4 h-20 w-20 opacity-10 group-hover:opacity-100 transition-opacity">
            
            <div class="flex items-center gap-4">
              <div class="flex-shrink-0">
                <img src="{{ $avatar }}" class="h-14 w-14 rounded-full object-cover shadow-sm" alt="Avatar">
              </div>
              <div class="flex-1">
                <div class="flex items-center gap-2 flex-wrap">
                  <div class="font-black text-[13px] text-[#123338] dark:text-white uppercase tracking-tight">{{ $u->name }}</div>
                  @if($flag)
                    <img src="{{ $flag }}" alt="" class="h-auto w-6 block">
                  @endif
                </div>
                @if($rol)
                  <div class="text-[9px] font-black text-[#02a676] uppercase tracking-widest mt-0.5">{{ $rol }}</div>
                @endif
              </div>
            </div>

            <div class="mt-4 pt-4 border-t border-gray-50 dark:border-white/5">
              <div class="px-2 py-1 rounded bg-[#6fa31c]/10 text-[#123338] dark:text-[#6fa31c] text-[9px] font-black uppercase tracking-widest inline-block mb-1">{{ $which }}</div>
              <div class="text-[11px] font-mono font-black text-gray-500 dark:text-gray-400 italic">{{ $fecha }}</div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>

  {{-- Listado del MES SELECCIONADO --}}
  <div class="space-y-4">
    <div class="flex items-center gap-4 px-2">
        <h2 class="text-[11px] font-black text-gray-400 uppercase tracking-[0.4em] italic">{{ $monthNames[$shownMonthNum] }}</h2>
        <div class="h-[1px] flex-1 bg-gray-100 dark:bg-white/5"></div>
    </div>

    @if(empty($monthItems))
      <div class="mx-2 p-8 rounded-2xl border border-dashed border-gray-200 dark:border-white/10 text-gray-400 text-[10px] font-black uppercase tracking-widest text-center">
        No hay resultados con los filtros seleccionados para este mes.
      </div>
    @else
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($monthItems as $row)
          @php
            $u      = $row['user'];
            $which  = \App\Models\User::humanMilestoneLabel($row['which']);
            $fecha  = $row['date']->isoFormat('D [de] MMMM YYYY');
            $flag   = $u->country_flag_url ?? null;
            $avatar = $u->avatar_url ?: 'https://ui-avatars.com/api/?name='.urlencode($u->name).'&background=E5E7EB&color=111827';
            $rol    = method_exists($u, 'primaryRoleName') ? $u->primaryRoleName() : null;
            $past   = (bool) $row['is_past'];
            $border = $past ? 'border-red-500/20 bg-red-50/10' : 'border-gray-100 dark:border-white/5 bg-white dark:bg-white/5';
          @endphp

          <div class="rounded-2xl border {{ $border }} p-4 transition-all hover:bg-gray-50 dark:hover:bg-white/[0.07]">
            <div class="flex items-center gap-3">
              <div class="flex-shrink-0">
                <img src="{{ $avatar }}" class="h-10 w-10 rounded-lg object-cover grayscale-[40%]" alt="Avatar">
              </div>
              <div class="flex-1">
                <div class="flex items-center gap-2 flex-wrap">
                  <div class="font-black text-[11px] text-[#123338] dark:text-gray-200 uppercase italic tracking-tight">{{ $u->name }}</div>
                  @if($flag)
                    <img src="{{ $flag }}" alt="" class="h-auto w-5 block">
                  @endif
                </div>
                @if($rol)
                  <div class="text-[8px] font-black text-gray-400 uppercase tracking-[0.2em]">{{ $rol }}</div>
                @endif
              </div>
            </div>

            <div class="mt-3 flex justify-between items-center flex-wrap gap-2">
              <div>
                <div class="px-2 py-0.5 rounded bg-gray-100 dark:bg-[#123338]/40 text-gray-500 dark:text-gray-300 text-[8px] font-black uppercase tracking-widest inline-block">{{ $which }}</div>
                <div class="text-[10px] font-mono font-black text-gray-400 dark:text-gray-500 italic mt-1">{{ $fecha }}</div>
              </div>
              @if($past)
                <span class="text-[8px] font-black text-red-500/50 uppercase italic tracking-tighter shrink-0">Event Past</span>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</div>