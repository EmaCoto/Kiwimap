<div class="flex h-full w-full flex-1 flex-col gap-8 p-6 bg-[#fcfcfc] dark:bg-[#0d1516] rounded-3xl">
  <div class="flex flex-col md:flex-row justify-between items-end gap-6 px-2">
    <div class="space-y-1">
      <div class="flex items-center gap-2">
        <span class="h-5 w-1 bg-[#351d5b] rounded-full"></span>
        <h1 class="text-3xl font-black text-[#123338] dark:text-white tracking-tighter uppercase italic">Registro de Licencias</h1>
      </div>
      <p class="text-[10px] font-black text-[#02a676] uppercase tracking-[0.5em] ml-3">Certificaciones Medicas / Control de Vigencia</p>
    </div>

    @can('create', \App\Models\License::class)
      <a href="{{ route('licenses.create') }}"
        class="group relative px-8 py-3 rounded-2xl bg-[#123338] dark:bg-white text-white dark:text-[#123338] text-[10px] font-black uppercase tracking-[0.2em] transition-all hover:scale-105 active:scale-95 shadow-2xl shadow-[#123338]/20">
        <div class="flex items-center gap-3">
          <flux:icon name="folder-plus" class="h-4 w-4 text-[#6fa31c]" />
          <span>Registrar Licencia</span>
        </div>
      </a>
    @endcan
  </div>

  @if (session('ok'))
    <div class="mx-2 p-4 rounded-2xl border border-[#02a676]/20 bg-[#02a676]/5 text-[#02a676] text-[10px] font-black uppercase tracking-widest flex items-center">
      <flux:icon name="bell" class="h-4 w-4 mr-4 animate-bounce" />
      {{ session('ok') }}
    </div>
  @endif

  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 px-2 items-end">
    <div class="relative group">
      <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2 block ml-1">Estado / Jurisdiccion</label>
      <select wire:model.live="stateCode" class="w-full bg-white dark:bg-[#123338]/20 border border-gray-100 dark:border-white/5 rounded-2xl py-3 px-4 text-[10px] font-black uppercase tracking-widest text-[#123338] dark:text-white outline-none appearance-none focus:border-[#02a676]">
        <option value="">TODOS LOS ESTADOS</option>
        @foreach($states as $s)
          <option value="{{ $s->code }}">
            {{ $s->name }} ({{ $s->code }}){{ $s->is_operational ? '' : ' - INACTIVO' }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="relative group">
      <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2 block ml-1">Estatus</label>
      <select wire:model.live="status" class="w-full bg-white dark:bg-[#123338]/20 border border-gray-100 dark:border-white/5 rounded-2xl py-3 px-4 text-[10px] font-black uppercase tracking-widest text-[#123338] dark:text-white outline-none appearance-none focus:border-[#02a676]">
        <option value="all">TODOS</option>
        <option value="active">ACTIVA</option>
        <option value="renovation">RENOVACION</option>
        <option value="expired">VENCIDA</option>
      </select>
    </div>

    <div class="md:col-span-2 relative group">
      <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2 block ml-1">Busqueda Inteligente</label>
      <div class="absolute bottom-3 left-4 flex items-center pointer-events-none">
        <flux:icon name="magnifying-glass" class="h-4 w-4 text-gray-400 group-focus-within:text-[#02a676]" />
      </div>
      <input type="text" wire:model.live.debounce.300ms="search"
        placeholder="DOCTOR, ID, ROL O ESTADO..."
        class="w-full bg-white dark:bg-[#123338]/20 border border-gray-100 dark:border-white/5 rounded-2xl py-3 pl-12 pr-4 text-[10px] font-black uppercase tracking-widest text-[#123338] dark:text-white outline-none focus:border-[#02a676] transition-all">
    </div>
  </div>

  <div class="flex justify-between items-center px-2">
    <button wire:click="clearFilters" class="group flex items-center gap-3 px-6 py-2 rounded-2xl bg-white dark:bg-[#123338]/40 border border-gray-100 dark:border-white/5 text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-[#c93d00] transition-all" type="button">
      <flux:icon name="paint-brush" class="h-4 w-4 group-hover:rotate-12 transition-transform" />
      <span>Limpiar Filtros</span>
    </button>
    <div class="flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5">
      <span class="text-[9px] font-black text-gray-400 uppercase tracking-tighter">Resultados:</span>
      <span class="text-[10px] font-black text-[#123338] dark:text-white italic">{{ $licenses->total() }}</span>
    </div>
  </div>

  <div class="bg-white dark:bg-[#123338]/10 rounded-lg shadow-2xl shadow-black/[0.02] border border-gray-100 dark:border-white/5 overflow-hidden">
    <div class="overflow-x-auto no-scrollbar">
      <table class="w-full text-left">
        <thead>
          <tr class="text-[9px] font-black text-gray-400 dark:text-gray-600 uppercase tracking-[0.2em] border-b border-gray-50 dark:border-white/5">
            <th class="px-6 py-5">ID</th>
            <th class="px-6 py-5">Doctor</th>
            <th class="px-6 py-5">Jurisdiccion</th>
            <th class="px-6 py-5 text-center">Vigencia (Emision / Expira)</th>
            <th class="px-6 py-5 text-center">Estatus</th>
            <th class="px-6 py-5 text-center">Link</th>
            <th class="px-6 py-5 text-right">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 dark:divide-white/5">
          @forelse($licenses as $l)
            <tr class="group hover:bg-[#123338]/[0.02] dark:hover:bg-white/[0.02] transition-all duration-300">
              <td class="px-6 py-6 text-[10px] font-mono font-black text-gray-400">#{{ $l->id }}</td>

              <td class="px-6 py-6">
                <div class="flex items-center gap-3">
                  @php
                    $user = $l->doctor?->user;
                    $src = $user->avatar_url ?? null;
                    $placeholder = 'https://ui-avatars.com/api/?name='.urlencode($user->name ?? 'D').'&background=123338&color=ffffff';
                  @endphp
                  <img src="{{ $src ?: $placeholder }}" class="h-9 w-9 rounded-xl object-cover border border-black/5 dark:border-white/10 group-hover:scale-110 transition-transform shadow-sm">
                  <div class="flex flex-col">
                    <span class="text-sm font-black text-[#123338] dark:text-gray-200 uppercase tracking-tighter italic leading-none group-hover:text-[#02a676] transition-colors">{{ $user->name ?? '—' }}</span>
                    <span class="text-[8px] font-bold text-gray-400 uppercase mt-1 tracking-widest">Especialista Verificado</span>
                  </div>
                </div>
              </td>

              <td class="px-6 py-6 text-[10px] font-bold text-[#123338] dark:text-gray-300 uppercase italic">
                {{ $l->state?->name }} <span class="text-gray-400 ml-1">({{ $l->state?->code }})</span>
                @if($l->state && ! $l->state->is_operational)
                  <span class="text-[#c93d00] ml-1">INACTIVO</span>
                @endif
              </td>

              <td class="px-6 py-6 text-center">
                <div class="flex flex-col items-center">
                  <span class="text-[10px] font-mono font-black text-gray-500">{{ optional($l->issued_date)->format('d . m . Y') ?? '--' }}</span>
                  <span class="h-3 w-[1px] bg-gray-100 dark:bg-white/5 my-0.5"></span>
                  <span class="text-[10px] font-mono font-black text-[#123338] dark:text-white">{{ optional($l->expiration_date)->format('d . m . Y') ?? '--' }}</span>
                </div>
              </td>

              <td class="px-6 py-6">
                <div class="flex justify-center">
                  @php
                    $status = $l->normalized_status;
                    $statusColor = [
                        'active' => '#02a676',
                        'renovation' => '#f56e2a',
                        'expired' => '#c93d00',
                    ][$status] ?? '#9ca3af';
                    $statusText = [
                        'active' => 'ACTIVA',
                        'renovation' => 'RENOVACION',
                        'expired' => 'VENCIDA',
                    ][$status] ?? strtoupper((string) $status);
                  @endphp
                  <div class="flex items-center gap-2 px-4 py-1.5 rounded-full border border-gray-100 dark:border-white/5 bg-white dark:bg-transparent shadow-sm">
                    <span class="h-1.5 w-1.5 rounded-full" style="background-color: {{ $statusColor }}; box-shadow: 0 0 8px {{ $statusColor }}"></span>
                    <span class="text-[8px] font-black uppercase text-gray-500 dark:text-gray-400 tracking-widest">{{ $statusText }}</span>
                  </div>
                </div>
              </td>

              <td class="px-6 py-6">
                <div class="flex justify-center">
                  @if($l->has_active_link)
                    <flux:icon name="check-circle" class="h-5 w-5 text-[#02a676]" variant="solid" />
                  @else
                    <flux:icon name="x-circle" class="h-5 w-5 text-gray-300 dark:text-gray-600" />
                  @endif
                </div>
              </td>

              <td class="px-6 py-6 text-right">
                <div class="flex justify-end gap-2">
                  <a href="{{ route('licenses.edit', $l) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gray-50 dark:bg-white/5 text-gray-400 hover:bg-[#123338] hover:text-white dark:hover:bg-white dark:hover:text-[#123338] transition-all shadow-sm">
                    <flux:icon name="pencil-square" class="h-4 w-4" />
                  </a>
                  @can('delete', $l)
                    <button x-data @click.prevent="if (confirm('Eliminar esta licencia?')) { $wire.delete({{ $l->id }}) }" type="button" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gray-50 dark:bg-white/5 text-gray-400 hover:bg-[#c93d00] hover:text-white transition-all shadow-sm">
                      <flux:icon name="trash" class="h-4 w-4" />
                    </button>
                  @endcan
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="9" class="p-24 text-center text-[10px] font-black uppercase tracking-[0.5em] opacity-20 italic">Sin Licencias Detectadas</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="px-2">
    {{ $licenses->links() }}
  </div>
</div>
