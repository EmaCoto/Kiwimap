<div x-data x-show="$wire.open" x-cloak class="fixed inset-0 z-50 flex items-start justify-center bg-[#123338]/40 backdrop-blur-sm">
  <div class="mt-10 w-full max-w-[96%] max-h-[90vh] overflow-y-auto rounded-3xl bg-white dark:bg-[#0d1516] p-8 shadow-2xl border border-white/20">

    
    <div class="flex items-center justify-between mb-8">
      <div class="space-y-1">
        <div class="flex items-center gap-2">
            <span class="h-5 w-1 bg-[#351d5b] rounded-full"></span>
            <h2 class="text-2xl font-black text-[#123338] dark:text-white tracking-tighter uppercase italic">Asistencia — <?php echo e($user?->name); ?></h2>
        </div>
        <p class="text-[10px] font-black text-[#6fa31c] uppercase tracking-[0.3em] ml-3">Registro Detallado de Jornada</p>
      </div>
      <button class="px-4 py-2 rounded-xl bg-gray-50 dark:bg-white/5 text-[10px] font-black uppercase tracking-widest text-gray-500 hover:bg-red-50 hover:text-red-600 transition-all shadow-sm" wire:click="close">Cerrar</button>
    </div>

    
    <div class="flex flex-wrap gap-4 mb-6 px-2">
        <div class="px-3 py-1.5 rounded-lg bg-[#123338]/5 border border-[#123338]/10 text-[10px] font-bold text-[#123338] dark:text-gray-400 uppercase tracking-tight">
            <span class="opacity-50 font-black">TZ:</span> <?php echo e($tzLabel); ?>

        </div>
        <div class="px-3 py-1.5 rounded-lg bg-[#123338]/5 border border-[#123338]/10 text-[10px] font-bold text-[#123338] dark:text-gray-400 uppercase tracking-tight">
            <span class="opacity-50 font-black">Hoy:</span> <?php echo e($todayStr); ?>

        </div>
        <div class="px-3 py-1.5 rounded-lg bg-[#02a676]/10 border border-[#02a676]/20 text-[10px] font-black text-[#02a676] uppercase tracking-widest">
            <?php echo e($rows[0]['status'] ?? '—'); ?>

        </div>
    </div>

    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
      <?php $stats = [['label' => 'Hoy', 'val' => $todayHhMm], ['label' => 'Semana', 'val' => $weekHhMm], ['label' => 'Mes', 'val' => $monthHhMm], ['label' => 'Año', 'val' => $yearHhMm]]; ?>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white dark:bg-white/5 border border-gray-100 dark:border-white/5 p-4 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
          <div class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1"><?php echo e($stat['label']); ?></div>
          <div class="text-2xl font-mono font-black text-[#123338] dark:text-white italic tracking-tighter"><?php echo e($stat['val']); ?></div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <div class="rounded-2xl border border-gray-100 dark:border-white/5 overflow-hidden bg-white dark:bg-white/5 shadow-sm">
      <div class="overflow-x-auto">
        <table class="min-w-full text-left border-collapse">
          <thead>
            <tr class="bg-gray-50 dark:bg-[#123338]/40 border-b border-gray-100 dark:border-white/10">
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['Fecha', 'Entrada', 'Break 1', 'Break 2', 'Lunch', 'Salida', 'Trabajado', 'Extra', 'Estado']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $th): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <th class="p-4 text-[10px] font-black text-[#123338] dark:text-gray-400 uppercase tracking-widest"><?php echo e($th); ?></th>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-50 dark:divide-white/5">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                <td class="p-4 text-[11px] font-bold text-gray-600 dark:text-gray-300 whitespace-nowrap"><?php echo e($row['date']); ?></td>
                <td class="p-4 text-[11px] font-mono font-black text-[#123338] dark:text-white"><?php echo e($row['in'] ?? '—'); ?></td>
                <td class="p-4 text-[10px] font-mono text-gray-500 whitespace-nowrap">
                  <?php echo e($row['b1s'] ?? '—'); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($row['b1e']): ?> <span class="text-[#6fa31c] mx-1">/</span> <?php echo e($row['b1e']); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
                <td class="p-4 text-[10px] font-mono text-gray-500 whitespace-nowrap">
                  <?php echo e($row['b2s'] ?? '—'); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($row['b2e']): ?> <span class="text-[#6fa31c] mx-1">/</span> <?php echo e($row['b2e']); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
                <td class="p-4 text-[10px] font-mono text-gray-500 whitespace-nowrap">
                  <?php echo e($row['ls'] ?? '—'); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($row['le']): ?> <span class="text-[#6fa31c] mx-1">/</span> <?php echo e($row['le']); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
                <td class="p-4 text-[11px] font-mono font-black text-[#123338] dark:text-white"><?php echo e($row['out'] ?? '—'); ?></td>
                <td class="p-4">
                    <span class="px-2 py-1 rounded-md bg-[#6fa31c]/10 text-[#6fa31c] text-[11px] font-black font-mono tracking-tighter"><?php echo e($row['worked']); ?></span>
                </td>
                <td class="p-4">
                    <span class="px-2 py-1 rounded bg-orange-100 text-orange-700 text-[11px] font-black">
                        Extra: <?php echo e($row['overtime']); ?>

                    </span>
                </td>
                <td class="p-4">
                    <span class="text-[9px] font-black uppercase italic tracking-tighter text-gray-400"><?php echo e($row['status']); ?></span>
                </td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <tr><td colspan="8" class="p-10 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.5em]">Sin registros de asistencia</td></tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </tbody>
        </table>
      </div>

      
      <div class="flex items-center justify-between p-4 bg-gray-50/50 dark:bg-[#123338]/20 border-t border-gray-100 dark:border-white/5">
        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paginator): ?>
            Página <span class="text-[#123338] dark:text-white"><?php echo e($paginator->currentPage()); ?></span> de <?php echo e($paginator->lastPage()); ?> <span class="mx-2">—</span> Total: <?php echo e($paginator->total()); ?>

          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <div class="flex gap-2">
          <button wire:click="previous" class="px-4 py-2 rounded-xl bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 text-[10px] font-black uppercase tracking-widest hover:bg-gray-50 transition-all disabled:opacity-30 shadow-sm" <?php if(!$paginator || !$paginator->previousPageUrl()): ?> disabled <?php endif; ?>>Anterior</button>
          <button wire:click="next" class="px-4 py-2 rounded-xl bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 text-[10px] font-black uppercase tracking-widest hover:bg-gray-50 transition-all disabled:opacity-30 shadow-sm" <?php if(!$paginator || !$paginator->nextPageUrl()): ?> disabled <?php endif; ?>>Siguiente</button>
        </div>
      </div>
    </div>

    
    <div class="mt-10">
      <div class="flex items-center gap-4 mb-4">
        <h3 class="text-[11px] font-black text-[#123338] dark:text-gray-400 uppercase tracking-[0.4em] italic">Historial mensual (últimos 12)</h3>
        <div class="h-[1px] flex-1 bg-gray-100 dark:bg-white/5"></div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <?php $m = \Illuminate\Support\Carbon::parse($h['month'])->isoFormat('MMMM YYYY'); ?>
          <div class="flex items-center justify-between p-4 rounded-2xl bg-gray-50/50 dark:bg-white/5 border border-gray-100 dark:border-white/5 transition-all hover:border-[#6fa31c]/30">
            <span class="text-[11px] font-bold text-gray-600 dark:text-gray-300 capitalize"><?php echo e($m); ?></span>
            <span class="text-[13px] font-mono font-black text-[#123338] dark:text-[#6fa31c] italic tracking-tighter"><?php echo e($h['hhmm']); ?></span>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full p-6 border border-dashed border-gray-200 rounded-2xl text-center text-[10px] font-black text-gray-400 uppercase tracking-widest">Sin historial disponible.</div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>
      <p class="mt-6 text-[9px] font-bold text-gray-400 italic tracking-tight leading-relaxed">
        * Se actualiza automáticamente al cerrar el mes. Si algún mes no existía en resumen, se calcula en tiempo real.
      </p>
    </div>
  </div>
</div>
<?php /**PATH C:\Users\EOchoa\Escritorio\Kiwimap\resources\views/livewire/users/attendance-modal.blade.php ENDPATH**/ ?>