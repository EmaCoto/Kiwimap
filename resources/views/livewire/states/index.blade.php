<div class="flex h-full w-full flex-1 flex-col gap-8 p-6 bg-[#fcfcfc] dark:bg-[#0d1516] rounded-3xl">
  
  {{-- Header: Estilo Ejecutivo --}}
  <div class="flex flex-col md:flex-row justify-between items-end gap-6 px-2">
    <div class="space-y-1">
      <div class="flex items-center gap-2">
        <span class="h-5 w-1 bg-[#351d5b] rounded-full"></span>
        <h1 class="text-3xl font-black text-[#123338] dark:text-white tracking-tighter uppercase italic">Jurisdicciones</h1>
      </div>
      <p class="text-[10px] font-black text-[#02a676] uppercase tracking-[0.5em] ml-3">Cobertura Estatal / Estatus de Operación</p>
    </div>
    
    @can('create', \App\Models\State::class)
      <a href="{{ route('states.create') }}" 
        class="group relative px-8 py-3 rounded-2xl bg-[#123338] dark:bg-white text-white dark:text-[#123338] text-[10px] font-black uppercase tracking-[0.2em] transition-all hover:scale-105 active:scale-95 shadow-2xl shadow-[#123338]/20">
        <div class="flex items-center gap-3">
          <flux:icon name="globe-americas" class="h-4 w-4 text-[#6fa31c]" />
          <span>Agregar Nuevo Estado</span>
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

  {{-- Filtros de Control --}}
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 px-2 items-end">
    <div class="md:col-span-3 relative group">
        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2 block ml-1">Búsqueda Global</label>
        <div class="absolute bottom-3 left-4 flex items-center pointer-events-none">
            <flux:icon name="magnifying-glass" class="h-4 w-4 text-gray-400 group-focus-within:text-[#02a676]" />
        </div>
        <input type="text" wire:model.live.debounce.300ms="search" 
            placeholder="NOMBRE O CÓDIGO ISO..." 
            class="w-full bg-white dark:bg-[#123338]/20 border border-gray-100 dark:border-white/5 rounded-2xl py-3 pl-12 pr-4 text-[10px] font-black uppercase tracking-widest text-[#123338] dark:text-white outline-none focus:border-[#02a676] transition-all">
    </div>

    <div class="relative group">
        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2 block ml-1">Filtro Operativo</label>
        <select wire:model.live="operational" 
            class="w-full bg-white dark:bg-[#123338]/20 border border-gray-100 dark:border-white/5 rounded-2xl py-3 px-4 text-[10px] font-black uppercase tracking-widest text-[#123338] dark:text-white outline-none appearance-none focus:border-[#02a676]">
            <option value="all">TODOS</option>
            <option value="yes">OPERACIONAL</option>
            <option value="no">NO OPERACIONAL</option>
        </select>
    </div>
  </div>

  {{-- Tabla: Estilo Reporte Geográfico --}}
  <div class="bg-white dark:bg-[#123338]/10 rounded-lg shadow-2xl shadow-black/[0.02] border border-gray-100 dark:border-white/5 overflow-hidden">
    <div class="overflow-x-auto no-scrollbar">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="text-[9px] font-black text-gray-400 dark:text-gray-600 uppercase tracking-[0.2em] border-b border-gray-50 dark:border-white/5">
            <th class="px-8 py-5">Nombre de la Jurisdicción</th>
            <th class="px-8 py-5 text-center">ID / Código</th>
            <th class="px-8 py-5 text-center">Estatus Operativo</th>
            <th class="px-8 py-5 text-right">Acciones de Sistema</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 dark:divide-white/5">
          @forelse($states as $s)
            <tr class="group hover:bg-[#123338]/[0.02] dark:hover:bg-white/[0.02] transition-all duration-300">
              <td class="px-8 py-6">
                <div class="text-sm font-black text-[#123338] dark:text-gray-200 uppercase tracking-tighter italic group-hover:text-[#02a676] transition-colors">
                    {{ $s->name }}
                </div>
              </td>
              <td class="px-8 py-6 text-center">
                <span class="text-[10px] font-mono font-black text-[#123338] dark:text-white bg-gray-100 dark:bg-white/5 px-3 py-1 rounded-lg border border-black/5 dark:border-white/5">
                    {{ $s->code }}
                </span>
              </td>
              <td class="px-8 py-6">
                <div class="flex justify-center">
                  @if($s->is_operational)
                    <div class="flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#02a676]/10 border border-[#02a676]/20">
                        <span class="h-1.5 w-1.5 rounded-full bg-[#02a676] animate-pulse"></span>
                        <span class="text-[8px] font-black uppercase text-[#02a676] tracking-widest">Activo</span>
                    </div>
                  @else
                    <div class="flex items-center gap-2 px-4 py-1.5 rounded-full bg-gray-100 dark:bg-white/5 border border-gray-200 dark:border-white/5">
                        <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                        <span class="text-[8px] font-black uppercase text-gray-500 tracking-widest">Inactivo</span>
                    </div>
                  @endif
                </div>
              </td>
              <td class="px-8 py-6 text-right">
                <div class="flex justify-end gap-2">
                    @can('update', $s)
                        <a href="{{ route('states.edit', $s) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gray-50 dark:bg-white/5 text-gray-400 hover:bg-[#123338] hover:text-white dark:hover:bg-white dark:hover:text-[#123338] transition-all">
                            <flux:icon name="pencil-square" class="h-4 w-4" />
                        </a>
                    @endcan
                    
                    @can('delete', $s)
                        <button x-data @click.prevent="if (confirm('¿Eliminar este estado?')) { $wire.delete({{ $s->id }}) }" 
                            type="button" 
                            class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gray-50 dark:bg-white/5 text-gray-400 hover:bg-[#c93d00] hover:text-white transition-all">
                            <flux:icon name="trash" class="h-4 w-4" />
                        </button>
                    @endcan
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="p-24 text-center">
                <p class="text-[10px] font-black uppercase tracking-[0.5em] opacity-20 italic">No hay estados configurados en el sistema</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="px-2">
    {{ $states->links() }}
  </div>
</div>