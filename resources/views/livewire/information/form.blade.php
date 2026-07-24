<div class="flex h-full w-full flex-1 flex-col gap-8 p-6 bg-[#fcfcfc] dark:bg-[#0d1516] rounded-3xl">
  <div class="flex flex-col md:flex-row justify-between items-end gap-6 px-2">
    <div class="space-y-1">
      <div class="flex items-center gap-2">
        <span class="h-5 w-1 bg-[#351d5b] rounded-full"></span>
        <h1 class="text-3xl font-black text-[#123338] dark:text-white tracking-tighter uppercase italic">
          {{ $isEdit ? 'Editar información' : 'Nueva información' }}
        </h1>
      </div>
      <p class="text-[10px] font-black text-[#02a676] uppercase tracking-[0.5em] ml-3">Directorio de datos / Notas internas</p>
    </div>

    <a href="{{ $redirect ?? route('information.index') }}"
       class="group flex items-center gap-3 px-6 py-3 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5 text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-[#123338] dark:hover:text-white transition-all">
      <flux:icon name="arrow-uturn-left" class="h-4 w-4 transition-transform group-hover:-translate-x-1" />
      <span>Volver</span>
    </a>
  </div>

  <div class="max-w-4xl bg-white dark:bg-[#123338]/10 rounded-[2rem] shadow-2xl shadow-black/[0.02] border border-gray-100 dark:border-white/5 p-8 md:p-10">
    <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="md:col-span-2 space-y-2">
        <div class="flex items-center justify-between gap-3">
          <label for="information-name" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] ml-1">Nombre</label>
          <span class="text-[9px] font-black text-gray-300 uppercase tracking-widest">{{ mb_strlen($name) }}/150</span>
        </div>
        <input id="information-name" type="text" wire:model.live.debounce.250ms="name" maxlength="150"
               class="w-full bg-gray-50 dark:bg-[#0d1516]/50 border border-gray-100 dark:border-white/5 rounded-2xl p-4 text-xs font-bold text-[#123338] dark:text-white focus:ring-2 focus:ring-[#02a676]/20 focus:border-[#02a676] transition-all outline-none"
               placeholder="Ej: Teléfono de soporte" required>
        @error('name') <p class="text-[9px] font-black text-rose-600 uppercase tracking-tighter mt-1 ml-1">{{ $message }}</p> @enderror
      </div>

      <div class="md:col-span-2 space-y-2">
        <div class="flex items-center justify-between gap-3">
          <label for="information-value" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] ml-1">Información</label>
          <span class="text-[9px] font-black text-gray-300 uppercase tracking-widest">{{ mb_strlen($information) }}/100</span>
        </div>
        <input id="information-value" type="text" wire:model.live.debounce.250ms="information" maxlength="100"
               class="w-full bg-gray-50 dark:bg-[#0d1516]/50 border border-gray-100 dark:border-white/5 rounded-2xl p-4 text-xs font-mono font-black text-[#123338] dark:text-white focus:ring-2 focus:ring-[#02a676]/20 focus:border-[#02a676] transition-all outline-none"
               placeholder="Texto, número, correo, enlace..." required>
        @error('information') <p class="text-[9px] font-black text-rose-600 uppercase tracking-tighter mt-1 ml-1">{{ $message }}</p> @enderror
      </div>

      <div class="md:col-span-2 space-y-2">
        <label for="information-notes" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] ml-1">Notas</label>
        <textarea id="information-notes" wire:model.defer="notes" rows="7"
                  class="w-full resize-y bg-gray-50 dark:bg-[#0d1516]/50 border border-gray-100 dark:border-white/5 rounded-2xl p-4 text-xs font-medium leading-relaxed text-[#123338] dark:text-white focus:ring-2 focus:ring-[#02a676]/20 focus:border-[#02a676] transition-all outline-none"
                  placeholder="Agrega aquí cualquier detalle o nota adicional..."></textarea>
        @error('notes') <p class="text-[9px] font-black text-rose-600 uppercase tracking-tighter mt-1 ml-1">{{ $message }}</p> @enderror
      </div>

      <div class="md:col-span-2 flex items-center gap-4 mt-6 justify-end">
        <a href="{{ $redirect ?? route('information.index') }}"
           class="px-8 py-4 rounded-2xl bg-gray-100 dark:bg-white/5 text-gray-500 dark:text-gray-400 text-[10px] font-black uppercase tracking-widest hover:bg-gray-200 dark:hover:bg-white/10 transition-all">
          Cancelar
        </a>
        <button type="submit" wire:loading.attr="disabled" wire:target="save"
                class="group relative px-10 py-4 rounded-2xl bg-[#123338] dark:bg-white text-white dark:text-[#123338] text-[10px] font-black uppercase tracking-[0.2em] transition-all hover:scale-105 active:scale-95 shadow-2xl shadow-[#123338]/20 disabled:cursor-wait disabled:opacity-60">
          <div class="flex items-center gap-3">
            <flux:icon name="check" class="h-4 w-4 text-[#6fa31c]" />
            <span wire:loading.remove wire:target="save">{{ $isEdit ? 'Actualizar información' : 'Guardar información' }}</span>
            <span wire:loading wire:target="save">Guardando...</span>
          </div>
        </button>
      </div>
    </form>
  </div>
</div>
