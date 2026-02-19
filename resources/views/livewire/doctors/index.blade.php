<div class="flex h-full w-full flex-1 flex-col gap-8 p-6 bg-[#fcfcfc] dark:bg-[#0d1516] rounded-3xl">
  
  {{-- Header: Estilo Ejecutivo --}}
  <div class="flex flex-col md:flex-row justify-between items-end gap-6 px-2">
    <div class="space-y-1">
      <div class="flex items-center gap-2">
        <span class="h-5 w-1 bg-[#351d5b] rounded-full"></span>
        <h1 class="text-3xl font-black text-[#123338] dark:text-white tracking-tighter uppercase italic">Cuerpo Médico</h1>
      </div>
      <p class="text-[10px] font-black text-[#02a676] uppercase tracking-[0.5em] ml-3">Base de Datos / Registro Profesional</p>
    </div>
    
    @can('create', \App\Models\Doctor::class)
      <a href="{{ route('doctors.create') }}" 
        class="group relative px-8 py-3 rounded-lg bg-[#123338] dark:bg-white text-white dark:text-[#123338] text-[10px] font-black uppercase tracking-[0.2em] transition-all hover:scale-105 active:scale-95 shadow-2xl shadow-[#123338]/20">
        <div class="flex items-center gap-3">
          <flux:icon name="user-plus" class="h-4 w-4 text-[#6fa31c]" />
          <span>Agregar Nuevo Doctor</span>
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

  {{-- Filtros y Estadísticas Rápidas --}}
  <div class="flex flex-col md:flex-row items-center justify-between gap-4 px-2">
    <div class="relative w-full md:w-96 group">
        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
            <flux:icon name="magnifying-glass" class="h-4 w-4 text-gray-400 group-focus-within:text-[#02a676] transition-colors" />
        </div>
        <input type="text" wire:model.live.debounce.300ms="search" 
            placeholder="BUSCAR POR NOMBRE, EMAIL O ESPECIALIDAD..." 
            class="w-full bg-white dark:bg-[#123338]/20 border border-gray-100 dark:border-white/5 rounded-2xl py-3 pl-12 pr-4 text-[10px] font-black uppercase tracking-widest text-[#123338] dark:text-white focus:ring-2 focus:ring-[#02a676]/20 focus:border-[#02a676] transition-all outline-none">
    </div>
    <div class="flex items-center gap-3 px-6 py-3 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5">
        <span class="text-[9px] font-black text-gray-400 uppercase tracking-tighter">Registros Totales:</span>
        <span class="text-[11px] font-black text-[#123338] dark:text-white italic">{{ $doctors->total() }}</span>
    </div>
  </div>

  {{-- Tabla: Estilo Reporte Ejecutivo --}}
  <div class="bg-white dark:bg-[#123338]/10 rounded-lg shadow-2xl shadow-black/[0.02] border border-gray-100 dark:border-white/5 overflow-hidden">
    <div class="overflow-x-auto no-scrollbar">
      <table class="w-full text-left">
        <thead>
          <tr class="text-[9px] font-black text-gray-400 dark:text-gray-600 uppercase tracking-[0.2em] border-b border-gray-50 dark:border-white/5">
            <th class="px-8 py-5">Identidad del Especialista</th>
            <th class="px-8 py-5">Contacto Oficial</th>
            <th class="px-8 py-5">Área de Especialidad</th>
            <th class="px-8 py-5 text-right">Gobernanza</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 dark:divide-white/5">
          @forelse($doctors as $d)
            <tr class="group hover:bg-[#123338]/[0.02] dark:hover:bg-white/[0.02] transition-all duration-300">
              <td class="px-8 py-6">
                <div class="text-sm font-black text-[#123338] dark:text-gray-200 uppercase tracking-tighter italic group-hover:text-[#02a676] transition-colors leading-none">
                    {{ $d->user?->name ?? 'Sin Identificar' }}
                </div>
                <div class="text-[8px] font-bold text-gray-400 uppercase mt-1.5 tracking-widest">Activo en Sistema</div>
              </td>
              <td class="px-8 py-6">
                <div class="text-[10px] font-bold text-gray-500 dark:text-gray-400 lowercase tracking-tight">{{ $d->user?->email ?? '—' }}</div>
              </td>
              <td class="px-8 py-6">
                <div class="inline-flex items-center px-3 py-1 rounded-lg bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/5">
                    <span class="text-[9px] font-black text-[#123338] dark:text-white uppercase tracking-tighter italic">{{ $d->specialty ?? 'General' }}</span>
                </div>
              </td>
              <td class="px-8 py-6 text-right">
                <div class="flex justify-end gap-2">
                    <a href="{{ route('doctors.edit', $d) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gray-50 dark:bg-white/5 text-gray-400 hover:bg-[#123338] hover:text-white dark:hover:bg-white dark:hover:text-[#123338] transition-all shadow-sm">
                        <flux:icon name="pencil-square" class="h-4 w-4" />
                    </a>

                    @can('delete', $d)
                    <button
                        x-data
                        @click.prevent="if (confirm('¿Seguro que quieres eliminar este doctor?')) { $wire.delete({{ $d->id }}) }"
                        type="button"
                        class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gray-50 dark:bg-white/5 text-gray-400 hover:bg-[#c93d00] hover:text-white transition-all shadow-sm"
                    >
                        <flux:icon name="trash" class="h-4 w-4" />
                    </button>
                    @endcan
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="p-24 text-center">
                <p class="text-[10px] font-black uppercase tracking-[0.5em] opacity-20 italic">No se han encontrado especialistas bajo este criterio</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- Paginación: Estilo Minimalista --}}
  <div class="px-2">
    {{ $doctors->links() }}
  </div>
</div>