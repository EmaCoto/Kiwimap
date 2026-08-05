<div x-data x-show="$wire.open" x-cloak class="fixed inset-0 z-50 flex items-start justify-center bg-[#123338]/40 backdrop-blur-sm">
  <div class="mt-10 w-full max-w-[650px] rounded-3xl bg-white dark:bg-[#0d1516] p-8 shadow-2xl border border-white/20">

    {{-- Header del Modal --}}
    <div class="flex items-center justify-between mb-8">
      <div class="space-y-1">
        <div class="flex items-center gap-2">
            <span class="h-5 w-1 bg-[#6fa31c] rounded-full"></span>
            <h2 class="text-xl font-black text-[#123338] dark:text-white tracking-tighter uppercase italic">Expediente de Usuario</h2>
        </div>
      </div>
      <button class="group p-2 rounded-xl hover:bg-red-50 dark:hover:bg-red-500/10 transition-all cursor-pointer" wire:click="close">
        <flux:icon name="x-circle" class="h-6 w-6 text-gray-400 group-hover:text-red-500" />
      </button>
    </div>

    @if($user)
      {{-- Card de Identidad Principal --}}
      <div class="flex items-center gap-5 mb-10 p-6 rounded-2xl bg-gray-50 dark:bg-[#123338]/20 border border-gray-100 dark:border-white/5">
        <div class="relative">
            <img
              src="{{ $user->avatar_url ?: 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=123338&color=ffffff' }}"
              class="h-20 w-20 rounded-2xl object-cover border-2 border-white dark:border-white/10 shadow-md"
              alt="Avatar"
            >
            <div class="absolute -bottom-2 -right-2">
                @if($user->country_flag_url)
                    <img src="{{ $user->country_flag_url }}" alt="" class="h-auto w-8 block border-0 shadow-none ring-0">
                @endif
            </div>
        </div>

        <div class="flex-1">
          <div class="text-2xl font-black text-[#123338] dark:text-white tracking-tighter uppercase italic leading-none">{{ $user->name }}</div>
          <div class="text-[11px] font-bold text-[#6fa31c] uppercase tracking-[0.2em] mt-1">{{ $user->email }}</div>

          <div class="mt-3 flex gap-2">
              <span class="px-2 py-0.5 rounded bg-[#123338] text-white text-[9px] font-black uppercase tracking-widest">Activo</span>
              @if($user->has_id_badge)
                <span class="px-2 py-0.5 rounded bg-[#6fa31c]/20 text-[#123338] dark:text-[#6fa31c] text-[9px] font-black uppercase tracking-widest">ID Badge OK</span>
              @endif
          </div>
        </div>
      </div>

      {{-- Grid de Datos Técnicos --}}
      <div class="grid grid-cols-2 gap-x-10 gap-y-6 px-4">

        <div class="group">
          <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-[#6fa31c] transition-colors">Número de empleado</div>
          <div class="text-sm font-mono font-black text-[#123338] dark:text-gray-200 italic">{{ $user->employee_number ?: '—' }}</div>
        </div>

        <div class="group">
          <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-[#6fa31c] transition-colors">País / Región</div>
          <div class="text-sm font-black text-[#123338] dark:text-gray-200 uppercase tracking-tight">{{ strtoupper($user->country_code ?? '—') }}</div>
        </div>

        <div class="group">
          <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-[#6fa31c] transition-colors">Fecha de Nacimiento</div>
          <div class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $user->birthday_long ?: '—' }}</div>
        </div>

        <div class="group">
          <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-[#6fa31c] transition-colors">Ingreso Dr. Kiwimed</div>
          <div class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $user->anniversary_kiwimed_long ?: '—' }}</div>
        </div>

        <div class="group">
          <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-[#6fa31c] transition-colors">Aniversario Grupo</div>
          <div class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $user->anniversary_group_long ?: '—' }}</div>
        </div>

        @php
          $hipaaExpired = $user->hipaa_course_expiration_date?->lt(today());
        @endphp
        <div class="group">
          <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-[#6fa31c] transition-colors">Vencimiento Curso HIPAA</div>
          <div class="flex items-center gap-2 flex-wrap">
            <div class="text-sm font-bold {{ $hipaaExpired ? 'text-rose-600' : 'text-gray-700 dark:text-gray-300' }}">{{ $user->hipaa_course_expiration_long ?: '—' }}</div>
            @if($user->hipaa_course_expiration_date)
              <span class="px-2 py-0.5 rounded-full text-[8px] font-black uppercase tracking-widest {{ $hipaaExpired ? 'bg-rose-500/10 text-rose-600' : 'bg-[#02a676]/10 text-[#02a676]' }}">
                {{ $hipaaExpired ? 'Vencido' : 'Vigente' }}
              </span>
            @endif
          </div>
        </div>

        <div class="group">
          <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 group-hover:text-[#6fa31c] transition-colors">ID Físico Entregado</div>
          <div class="text-sm font-black text-[#123338] dark:text-white uppercase tracking-tighter">{{ $user->has_id_badge ? 'Confirmado' : 'Pendiente' }}</div>
        </div>

        <div class="pt-4 border-t border-gray-100 dark:border-white/5 group">
          <div class="text-[9px] font-black text-[#351d5b] dark:text-indigo-400 uppercase tracking-widest mb-1">Línea Spruce</div>
          <div class="text-sm font-mono font-black text-gray-600 dark:text-gray-400 italic">{{ $user->spruce_number ?: '—' }}</div>
        </div>

        <div class="pt-4 border-t border-gray-100 dark:border-white/5 group">
          <div class="text-[9px] font-black text-[#351d5b] dark:text-indigo-400 uppercase tracking-widest mb-1">Línea Crecer</div>
          <div class="text-sm font-mono font-black text-gray-600 dark:text-gray-400 italic">{{ $user->crecer_number ?: '—' }}</div>
        </div>
      </div>

    @else
      <div class="py-20 text-center">
          <div class="text-[10px] font-black text-gray-400 uppercase tracking-[0.5em]">Cargando expediente...</div>
      </div>
    @endif
  </div>
</div>
