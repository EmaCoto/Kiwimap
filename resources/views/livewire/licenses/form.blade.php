<div class="flex h-full w-full flex-1 flex-col gap-8 p-6 bg-[#fcfcfc] dark:bg-[#0d1516] rounded-3xl">
  <div class="flex flex-col md:flex-row justify-between items-end gap-6 px-2">
    <div class="space-y-1">
      <div class="flex items-center gap-2">
        <span class="h-5 w-1 bg-[#351d5b] rounded-full"></span>
        <h1 class="text-3xl font-black text-[#123338] dark:text-white tracking-tighter uppercase italic">
          {{ $isEdit ? 'Gestion: Editar Licencia' : 'Certificacion: Nueva Licencia' }}
        </h1>
      </div>
      <p class="text-[10px] font-black text-[#02a676] uppercase tracking-[0.5em] ml-3">Validacion de Credenciales / Registro de Vigencia</p>
    </div>

    <a href="{{ $redirect ?? route('licenses.index') }}"
       class="group flex items-center gap-3 px-6 py-3 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5 text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-[#123338] dark:hover:text-white transition-all">
      <flux:icon name="arrow-uturn-left" class="h-4 w-4 transition-transform group-hover:-translate-x-1" />
      <span>Volver</span>
    </a>
  </div>

  @if (session('ok'))
    <div class="mx-2 p-4 rounded-2xl border border-[#02a676]/20 bg-[#02a676]/5 text-[#02a676] text-[10px] font-black uppercase tracking-widest flex items-center">
      <flux:icon name="bell" class="h-4 w-4 mr-4 animate-bounce" />
      {{ session('ok') }}
    </div>
  @endif

  <div class="max-w-4xl bg-white dark:bg-[#123338]/10 rounded-[2rem] shadow-2xl shadow-black/[0.02] border border-gray-100 dark:border-white/5 p-8 md:p-12">
    <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <div class="space-y-2">
        <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] ml-1">Especialista Medico</label>
        <div class="relative group">
          <select wire:model="doctor_id"
            class="w-full bg-gray-50 dark:bg-[#0d1516]/50 border border-gray-100 dark:border-white/5 rounded-2xl p-4 text-xs font-bold text-[#123338] dark:text-white appearance-none focus:ring-2 focus:ring-[#02a676]/20 focus:border-[#02a676] transition-all outline-none">
            <option value="">SELECCIONE...</option>
            @foreach($doctors as $d)
              <option value="{{ $d->id }}">
                {{ strtoupper($d->user?->name) }}{{ $d->specialty ? ' - '.$d->specialty : '' }}
              </option>
            @endforeach
          </select>
          <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
            <flux:icon name="chevron-down" class="h-4 w-4 text-gray-400" />
          </div>
        </div>
        @error('doctor_id') <p class="text-[9px] font-black text-rose-600 uppercase tracking-tighter mt-1 ml-1">{{ $message }}</p> @enderror
      </div>

      <div class="space-y-2">
        <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] ml-1">Jurisdiccion Estatal</label>
        <div class="relative group">
          <select wire:model="state_id"
            class="w-full bg-gray-50 dark:bg-[#0d1516]/50 border border-gray-100 dark:border-white/5 rounded-2xl p-4 text-xs font-bold text-[#123338] dark:text-white appearance-none focus:ring-2 focus:ring-[#02a676]/20 focus:border-[#02a676] transition-all outline-none">
            <option value="">SELECCIONE...</option>
            @foreach($states as $s)
              <option value="{{ $s->id }}">{{ strtoupper($s->name) }} ({{ $s->code }}){{ $s->is_operational ? '' : ' - INACTIVO' }}</option>
            @endforeach
          </select>
          <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
            <flux:icon name="chevron-down" class="h-4 w-4 text-gray-400" />
          </div>
        </div>
        @error('state_id') <p class="text-[9px] font-black text-rose-600 uppercase tracking-tighter mt-1 ml-1">{{ $message }}</p> @enderror
      </div>

      <div class="space-y-2">
        <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] ml-1">Fecha de Emision</label>
        <input type="date" wire:model="issued_date"
          class="w-full bg-gray-50 dark:bg-[#0d1516]/50 border border-gray-100 dark:border-white/5 rounded-2xl p-4 text-xs font-bold text-[#123338] dark:text-white focus:ring-2 focus:ring-[#02a676]/20 focus:border-[#02a676] transition-all outline-none">
        @error('issued_date') <p class="text-[9px] font-black text-rose-600 uppercase tracking-tighter mt-1 ml-1">{{ $message }}</p> @enderror
      </div>

      <div class="space-y-2">
        <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] ml-1">Fecha de Expiracion</label>
        <input type="date" wire:model="expiration_date"
          class="w-full bg-gray-50 dark:bg-[#0d1516]/50 border border-gray-100 dark:border-white/5 rounded-2xl p-4 text-xs font-bold text-[#123338] dark:text-white focus:ring-2 focus:ring-[#02a676]/20 focus:border-[#02a676] transition-all outline-none">
        @error('expiration_date') <p class="text-[9px] font-black text-rose-600 uppercase tracking-tighter mt-1 ml-1">{{ $message }}</p> @enderror
      </div>

      <div class="space-y-2">
        <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] ml-1">Estatus del Registro</label>
        <div class="relative group">
          <select wire:model="status"
            class="w-full bg-gray-50 dark:bg-[#0d1516]/50 border border-gray-100 dark:border-white/5 rounded-2xl p-4 text-xs font-bold text-[#123338] dark:text-white appearance-none focus:ring-2 focus:ring-[#02a676]/20 focus:border-[#02a676] transition-all outline-none">
            <option value="active">ACTIVA</option>
            <option value="renovation">EN RENOVACION</option>
            <option value="expired">VENCIDA</option>
          </select>
          <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
            <flux:icon name="chevron-down" class="h-4 w-4 text-gray-400" />
          </div>
        </div>
        @error('status') <p class="text-[9px] font-black text-rose-600 uppercase tracking-tighter mt-1 ml-1">{{ $message }}</p> @enderror
      </div>

      <div class="flex items-center gap-4 px-6 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5">
        <div class="relative flex items-center">
          <input id="has_link" type="checkbox" wire:model="has_active_link"
            class="w-5 h-5 rounded-lg border-gray-300 text-[#02a676] focus:ring-[#02a676] cursor-pointer shadow-sm">
        </div>
        <label for="has_link" class="text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest cursor-pointer select-none leading-tight">
          Vinculo de Verificacion Activo
        </label>
      </div>

      <div class="md:col-span-2 flex items-center gap-4 mt-8 justify-end">
        <a href="{{ $redirect ?? route('licenses.index') }}"
           class="px-8 py-4 rounded-2xl bg-gray-100 dark:bg-white/5 text-gray-500 dark:text-gray-400 text-[10px] font-black uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-white/10 transition-all">
          Cancelar
        </a>

        <button wire:loading.class="opacity-50" type="submit"
          class="group relative px-10 py-4 rounded-2xl bg-[#123338] dark:bg-white text-white dark:text-[#123338] text-[10px] font-black uppercase tracking-[0.2em] transition-all hover:scale-105 active:scale-95 shadow-2xl shadow-[#123338]/20">
          <div class="flex items-center gap-3">
            <flux:icon name="check" class="h-4 w-4 text-[#6fa31c]" />
            <span>{{ $isEdit ? 'Guardar Cambios' : 'Generar Licencia' }}</span>
          </div>
        </button>
      </div>
    </form>
  </div>
</div>
