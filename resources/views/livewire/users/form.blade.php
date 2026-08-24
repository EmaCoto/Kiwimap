<div class="max-w-4xl mx-auto p-8 space-y-10 bg-[#fcfcfc] dark:bg-[#0d1516] rounded-3xl shadow-sm border border-gray-100 dark:border-white/5">

  {{-- Encabezado Ejecutivo --}}
  <div class="flex items-center justify-between border-b border-gray-100 dark:border-white/5 pb-6">
    <div class="space-y-1">
      <div class="flex items-center gap-2">
        <span class="h-6 w-1 bg-[#351d5b] rounded-full"></span>
        <h1 class="text-3xl font-black text-[#123338] dark:text-white tracking-tighter uppercase italic">
          {{ $isEdit ? 'Editar usuario' : 'Nuevo usuario' }}
        </h1>
      </div>
      <p class="text-[10px] font-black text-[#6fa31c] uppercase tracking-[0.3em] ml-3">Panel de Gestión de Talento</p>
    </div>

    <a href="{{ $redirect ?? route('users.index') }}" class="flex items-center px-4 py-2 rounded-xl bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 text-[10px] font-black uppercase tracking-widest text-gray-500 hover:bg-gray-50 transition-all shadow-sm">
      <flux:icon name="arrow-uturn-left" class="h-3 w-3 mr-2" />Volver
    </a>
  </div>

  @if (session('ok'))
    <div class="p-4 rounded-2xl bg-[#02a676]/10 border border-[#02a676]/20 text-[#02a676] text-xs font-black uppercase tracking-widest animate-pulse">
      {{ session('ok') }}
    </div>
  @endif

  <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

    {{-- Información Básica --}}
    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="md:col-span-2">
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Nombre Completo</label>
        <input type="text" wire:model.defer="name" class="w-full bg-white dark:bg-[#123338]/20 border border-gray-200 dark:border-white/10 rounded-xl p-3 text-sm font-bold text-[#123338] dark:text-white focus:ring-2 focus:ring-[#6fa31c] focus:border-transparent outline-none transition-all" placeholder="Ej: Emanuel Cortes Ochoa o Dr. Sergio Angel">
        @error('name') <p class="text-[10px] font-black text-rose-600 uppercase tracking-tighter mt-1 ml-1">{{ $message }}</p> @enderror
      </div>

      <div class="md:col-span-2">
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Email Corporativo</label>
        <input type="email" wire:model.defer="email" class="w-full bg-white dark:bg-[#123338]/20 border border-gray-200 dark:border-white/10 rounded-xl p-3 text-sm font-bold text-[#123338] dark:text-white focus:ring-2 focus:ring-[#6fa31c] outline-none" placeholder="Ej: example@drkiwimed.com">
        @error('email') <p class="text-[10px] font-black text-rose-600 uppercase tracking-tighter mt-1 ml-1">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Contraseña {{ $isEdit ? '(Omitir para mantener)' : '' }}</label>
        <input type="password" wire:model.defer="password" class="w-full bg-white dark:bg-[#123338]/20 border border-gray-200 dark:border-white/10 rounded-xl p-3 text-sm focus:ring-2 focus:ring-[#6fa31c] outline-none" autocomplete="new-password">
        @error('password') <p class="text-[10px] font-black text-rose-600 uppercase tracking-tighter mt-1 ml-1">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Confirmar Seguridad</label>
        <input type="password" wire:model.defer="password_confirmation" class="w-full bg-white dark:bg-[#123338]/20 border border-gray-200 dark:border-white/10 rounded-xl p-3 text-sm focus:ring-2 focus:ring-[#6fa31c] outline-none" autocomplete="new-password">
      </div>
    </div>

    {{-- Datos de RRHH --}}
    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-6 border-t border-gray-100 dark:border-white/5">
      <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Nº Empleado</label>
        <input type="text" wire:model.defer="employee_number" class="w-full bg-white dark:bg-[#123338]/20 border border-gray-200 dark:border-white/10 rounded-xl p-3 text-sm font-black font-mono text-[#123338] dark:text-white" placeholder="120301">
      </div>

      <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Nacimiento</label>
        <input type="date" wire:model.defer="birthday" class="w-full bg-white dark:bg-[#123338]/20 border border-gray-200 dark:border-white/10 rounded-xl p-3 text-sm font-bold text-[#123338] dark:text-white">
      </div>

      <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Aniv. Dr. Kiwimed</label>
        <input type="date" wire:model.defer="anniversary_kiwimed" class="w-full bg-white dark:bg-[#123338]/20 border border-gray-200 dark:border-white/10 rounded-xl p-3 text-sm font-bold text-[#123338] dark:text-white">
      </div>

      <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Aniv. Grupo</label>
        <input type="date" wire:model.defer="anniversary_group" class="w-full bg-white dark:bg-[#123338]/20 border border-gray-200 dark:border-white/10 rounded-xl p-3 text-sm font-bold text-[#123338] dark:text-white">
      </div>

      <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Vencimiento Curso HIPAA</label>
        <input type="date" wire:model.defer="hipaa_course_expiration_date" class="w-full bg-white dark:bg-[#123338]/20 border border-gray-200 dark:border-white/10 rounded-xl p-3 text-sm font-bold text-[#123338] dark:text-white focus:ring-2 focus:ring-[#6fa31c] outline-none">
        @error('hipaa_course_expiration_date') <p class="text-[10px] font-black text-rose-600 uppercase tracking-tighter mt-1 ml-1">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Ubicación / País</label>
        <select wire:model.defer="country_code" class="w-full bg-white dark:bg-[#123338]/20 border border-gray-200 dark:border-white/10 rounded-xl p-3 text-sm font-bold text-[#123338] dark:text-white focus:ring-2 focus:ring-[#6fa31c] outline-none">
          <option value="">— Seleccionar —</option>
          <option value="co">Colombia</option>
          <option value="mx">México</option>
          <option value="cr">Costa Rica</option>
          <option value="pr">Puerto Rico</option>
          <option value="us">Estados Unidos</option>
        </select>
      </div>

      <div class="flex items-center gap-3 bg-[#6fa31c]/5 rounded-2xl px-4 py-3 border border-[#6fa31c]/10 self-end h-12.5">
        <input type="checkbox" wire:model.defer="has_id_badge" class="w-5 h-5 rounded border-gray-300 text-[#6fa31c] focus:ring-[#6fa31c]">
        <label class="text-[10px] font-black text-[#123338] dark:text-[#6fa31c] uppercase tracking-widest cursor-pointer">ID Badge Entregado</label>
      </div>
    </div>

    {{-- Comunicación --}}
    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Número Spruce (Opcional)</label>
        <input type="text" wire:model.defer="spruce_number" class="w-full bg-white dark:bg-[#123338]/20 border border-gray-200 dark:border-white/10 rounded-xl p-3 text-sm font-mono font-bold" placeholder="+1 (###) ###-####">
      </div>

      <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Número Crecer (Opcional)</label>
        <input type="text" wire:model.defer="crecer_number" class="w-full bg-white dark:bg-[#123338]/20 border border-gray-200 dark:border-white/10 rounded-xl p-3 text-sm font-mono font-bold" placeholder="+1 (###) ###-####">
      </div>
    </div>

    {{-- Roles y Permisos --}}
    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8 pt-6 border-t border-gray-100 dark:border-white/5">
      {{-- Columna Roles --}}
      <div class="space-y-4">
        <label class="block text-[10px] font-black text-[#123338] dark:text-gray-400 uppercase tracking-[0.3em] ml-1 italic">Asignación de Roles</label>
        <div class="bg-gray-50/50 dark:bg-white/5 border border-gray-100 dark:border-white/10 rounded-2xl p-4 max-h-56 overflow-auto space-y-2">
          @forelse($allRoles as $r)
            <label class="flex items-center gap-3 p-2 rounded-xl hover:bg-white dark:hover:bg-[#123338]/40 transition-all cursor-pointer group">
              <input type="checkbox" value="{{ $r }}" wire:model="roles" class="w-4 h-4 rounded border-gray-300 text-[#351d5b] focus:ring-[#351d5b]">
              <span class="text-xs font-bold text-gray-600 dark:text-gray-300 group-hover:text-[#123338]">{{ $r }}</span>
            </label>
          @empty
            <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest p-4 text-center">No hay roles definidos</div>
          @endforelse
        </div>
      </div>

      {{-- Columna Heredados --}}
      <div class="space-y-4">
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] ml-1 italic">Permisos Heredados</label>
        <div class="bg-neutral-100/50 dark:bg-white/5 border border-dashed border-gray-200 dark:border-white/10 rounded-2xl p-4 max-h-56 overflow-auto space-y-2">
          @forelse($inheritedOptions as $op)
            <div class="flex items-center justify-between p-2 opacity-70">
              <div class="flex items-center gap-3">
                <input type="checkbox" checked disabled class="w-4 h-4 rounded border-gray-300 bg-gray-200">
                <span class="text-xs font-bold text-gray-500">{{ $op['label'] }}</span>
              </div>
              <span class="text-[8px] font-black uppercase px-2 py-0.5 rounded-full bg-gray-200 dark:bg-white/10 text-gray-500 tracking-tighter italic">Heredado</span>
            </div>
          @empty
            <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest p-4 text-center italic">Ninguno por rol</div>
          @endforelse
        </div>
      </div>
    </div>

    {{-- Permisos Directos --}}
    <div class="md:col-span-2 space-y-4 pt-6">
      <label class="block text-[10px] font-black text-[#351d5b] dark:text-[#6fa31c] uppercase tracking-[0.3em] ml-1 italic">Privilegios Directos de Usuario</label>
      <div class="bg-white dark:bg-[#123338]/10 border border-gray-100 dark:border-white/5 rounded-2xl p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 max-h-72 overflow-auto shadow-inner">
        @forelse($permOptions as $op)
          <label class="flex items-center gap-3 p-2 rounded-xl border border-transparent hover:border-[#6fa31c]/20 hover:bg-[#6fa31c]/5 transition-all cursor-pointer group">
            <input type="checkbox" value="{{ $op['name'] }}" wire:model="permissions" class="w-4 h-4 rounded border-gray-300 text-[#6fa31c] focus:ring-[#6fa31c]">
            <span class="text-xs font-bold text-gray-600 dark:text-gray-300 group-hover:text-[#123338]">{{ $op['label'] }}</span>
          </label>
        @empty
          <div class="col-span-full text-[10px] font-black text-gray-400 uppercase tracking-widest text-center py-4 italic">No hay permisos disponibles</div>
        @endforelse
      </div>
      @error('permissions.*') <p class="text-[10px] font-black text-rose-600 uppercase tracking-tighter mt-1 ml-1">{{ $message }}</p> @enderror
    </div>

    {{-- Acciones --}}
    <div class="md:col-span-2 flex items-center gap-4 mt-8 pt-8 border-t border-gray-100 dark:border-white/5 justify-end">
      <a href="{{ $redirect ?? route('users.index') }}" class="px-6 py-3 rounded-2xl bg-gray-100 dark:bg-white/5 text-[10px] font-black text-gray-500 uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-white/10 transition-all shadow-sm">
        Cancelar
      </a>
      <button type="submit" class="flex items-center px-8 py-3 rounded-2xl bg-linear-to-t from-[#123338] to-[#1a444a] text-white text-[10px] font-black uppercase tracking-[0.2em] shadow-xl hover:scale-105 active:scale-95 transition-all">
        {{ $isEdit ? 'Actualizar Registro' : 'Crear Usuario' }}
      </button>
    </div>
  </form>
</div>
