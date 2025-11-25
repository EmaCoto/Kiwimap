<div class="max-w-6xl mx-auto p-6 space-y-8">
  {{-- Encabezado + filtros --}}
  <div class="flex flex-wrap items-end gap-3">
    <h1 class="text-xl font-semibold">Próximos Cumpleaniversario</h1>

    <div class="ms-auto flex gap-2">
      {{-- Filtro de mes --}}
      <div>
        <label class="block text-xs font-medium mb-1">Mes</label>
        <select wire:model.live="month" class="border rounded p-2 text-sm">
          <option value="" class="dark:text-black">Mes actual</option>
          @foreach($monthNames as $num => $name)
            <option value="{{ $num }}" class="dark:text-black">{{ $name }}</option>
          @endforeach
        </select>
      </div>

      {{-- Filtro de tipo --}}
      <div>
        <label class="block text-xs font-medium mb-1">Tipo</label>
        <select wire:model.live="type" class="border rounded p-2 text-sm">
          <option value="all" class="dark:text-black">Todos</option>
          <option value="birthday" class="dark:text-black">Cumpleaños</option>
          <option value="kiwimed" class="dark:text-black">Aniversario Dr. Kiwimed</option>
          <option value="group" class="dark:text-black">Aniversario Grupo</option>
        </select>
      </div>

      {{-- Limpiar filtros --}}
      <div class="self-end">
        <button wire:click="clearFilters" type="button" class="px-3 py-2 rounded-md bg-gradient-to-t from-[#6fa31c] to-[#123338] cursor-pointer text-white text-sm hover:scale-105 transition">Limpiar filtros</button>
      </div>
    </div>
    <hr class="w-full">
  </div>

  {{-- Sección fija: Próximos del mes ACTUAL (SIEMPRE visible; solo >= hoy; todos los tipos) --}}
  <div class="space-y-3">
    <h2 class="text-lg">Cumpleaniversarios de {{ $monthNames[$currentMonthNum] }}</h2>

    @if(empty($upcomingCurrentMonth))
      <div class="p-4 rounded border text-gray-600 text-sm dark:text-gray-400">
        No hay próximos hitos para el resto del mes.
      </div>
    @else
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
        @foreach($upcomingCurrentMonth as $row)
          @php
            /** @var \App\Models\User $u */
            $u      = $row['user'];
            $which  = \App\Models\User::humanMilestoneLabel($row['which']);
            $fecha  = $row['date']->isoFormat('D [de] MMMM YYYY');
            $flag   = $u->country_flag_url ?? null;
            $avatar = $u->avatar_url ?: 'https://ui-avatars.com/api/?name='.urlencode($u->name).'&background=E5E7EB&color=111827';
            $rol    = method_exists($u, 'primaryRoleName') ? $u->primaryRoleName() : null;
          @endphp

          <div class="rounded border p-3 hover:shadow-lg relative overflow-hidden">
            <img src="{{ asset('img/ballons.gif') }}" alt="" class="absolute right-0">
            <div class="flex items-center gap-3">
              <img src="{{ $avatar }}" class="h-12 w-12 rounded-full object-contain border" alt="Avatar">
              <div class="min-w-0">
                <div class="flex items-center gap-2">
                  <div class="font-semibold truncate">{{ $u->name }}</div>
                  @if($flag)
                    <img src="{{ $flag }}" alt="{{ strtoupper($u->country_code ?? '') }}" title="{{ strtoupper($u->country_code ?? '') }}" class="h-4 w-6 rounded object-cover">
                  @endif
                </div>
                @if($rol)
                  <div class="text-xs text-gray-600">
                    <span class="font-medium">{{ $rol }}</span>
                  </div>
                @endif
              </div>
            </div>

            <div class="mt-3">
              <div class="px-2 py-1 rounded bg-[#6fa31c1c] text-[#123338] text-[11px] inline-block">{{ $which }}</div>
              <div class="text-sm mt-1 text-gray-800">{{ $fecha }}</div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>

  {{-- Listado del MES SELECCIONADO (o actual si null) - respeta filtro de tipo - todo junto --}}
  <div class="space-y-3">
    <hr class="w-full">
    <h2 class="text-lg">{{ $monthNames[$shownMonthNum] }}</h2>

    @if(empty($monthItems))
      <div class="p-4 rounded border text-gray-600 text-sm">
        No hay resultados con los filtros seleccionados para este mes.
      </div>
    @else
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
        @foreach($monthItems as $row)
          @php
            /** @var \App\Models\User $u */
            $u      = $row['user'];
            $which  = \App\Models\User::humanMilestoneLabel($row['which']);
            $fecha  = $row['date']->isoFormat('D [de] MMMM YYYY');
            $flag   = $u->country_flag_url ?? null;
            $avatar = $u->avatar_url ?: 'https://ui-avatars.com/api/?name='.urlencode($u->name).'&background=E5E7EB&color=111827';
            $rol    = method_exists($u, 'primaryRoleName') ? $u->primaryRoleName() : null;
            $past   = (bool) $row['is_past'];
            $border = $past ? 'border-red-500' : 'border-gray-200';
          @endphp

          <div class="rounded border {{ $border }} p-3 hover:shadow-lg">
            <div class="flex items-center gap-3">
              <img src="{{ $avatar }}" class="h-12 w-12 rounded-full object-contain border" alt="Avatar">
              <div class="min-w-0">
                <div class="flex items-center gap-2">
                  <div class="font-semibold truncate">{{ $u->name }}</div>
                  @if($flag)
                    <img src="{{ $flag }}" alt="{{ strtoupper($u->country_code ?? '') }}" title="{{ strtoupper($u->country_code ?? '') }}" class="h-4 w-6 rounded object-cover">
                  @endif
                </div>
                @if($rol)
                  <div class="text-xs text-gray-600 dark:text-gray-400">
                    <span class="font-medium">{{ $rol }}</span>
                  </div>
                @endif
              </div>
            </div>

            <div class="mt-3">
              <div class="px-2 py-1 rounded bg-[#6fa31c1c] dark:text-gray-200 text-[#123338] text-[11px] inline-block">{{ $which }}</div>
              <div class="text-sm mt-1 text-gray-800 dark:text-gray-200">{{ $fecha }}</div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</div>
