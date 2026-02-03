<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('ok')): ?>
    <div class="p-3 rounded border-l-2 border-green-800 bg-green-100 text-green-800 text-sm flex items-center"><?php if (isset($component)) { $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.index','data' => ['name' => 'bell','class' => 'h-4 w-4 mr-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'bell','class' => 'h-4 w-4 mr-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2)): ?>
<?php $attributes = $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2; ?>
<?php unset($__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2)): ?>
<?php $component = $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2; ?>
<?php unset($__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2); ?>
<?php endif; ?><?php echo e(session('ok')); ?></div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()?->hasAnyRole(['Admin','Office Manager'])): ?>
    <div class="flex justify-end">
      <button x-data @click.prevent="if (confirm('¿Seguro que quieres limpiar todas las cachés?')) { $wire.clearCaches() }" wire:loading.attr="disabled" wire:target="clearCaches" class="flex items-center gap-2 px-3 py-2 rounded-lg text-white bg-gray-900 hover:opacity-90 text-sm" type="button">
        <?php if (isset($component)) { $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.index','data' => ['name' => 'bolt','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'bolt','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2)): ?>
<?php $attributes = $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2; ?>
<?php unset($__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2)): ?>
<?php $component = $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2; ?>
<?php unset($__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2); ?>
<?php endif; ?>
        <span wire:loading.remove wire:target="clearCaches">Limpiar caché</span>
        <span wire:loading wire:target="clearCaches">Procesando…</span>
      </button>
    </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  
  
  <div class="grid auto-rows-min gap-4 md:grid-cols-4">
    <div class="relative overflow-hidden rounded-lg group hover:shadow shadow-[#31353d] dark:shadow-[#4a4e58] bg-gradient-to-t dark:bg-gradient-to-b from-[#6fa31c] to-[#123338] hover:bg-none transition ease-in-out duration-300 p-5">
      <p class="text-xs text-gray-300 dark:group-hover:text-gray-300 group-hover:text-neutral-500 mb-2">Estados operando</p>
      <div class="text-3xl text-gray-100 dark:group-hover:text-gray-100 group-hover:text-black font-semibold"><?php echo e($operationalStates); ?></div>
    </div>

    <div class="relative overflow-hidden rounded-lg group hover:shadow shadow-[#31353d] dark:shadow-[#4a4e58] bg-gradient-to-t dark:bg-gradient-to-b from-[#6fa31c] to-[#123338] hover:bg-none transition ease-in-out duration-300 p-5">
      <p class="text-xs text-gray-300 dark:group-hover:text-gray-300 group-hover:text-neutral-500 mb-2">Doctores</p>
      <div class="text-3xl text-gray-100 dark:group-hover:text-gray-100 group-hover:text-black font-semibold"><?php echo e($doctorsCount); ?></div>
    </div>

    <div class="relative overflow-hidden rounded-lg group hover:shadow shadow-[#31353d] dark:shadow-[#4a4e58] bg-gradient-to-t dark:bg-gradient-to-b from-[#6fa31c] to-[#123338] hover:bg-none transition ease-in-out duration-300 p-5">
      <p class="text-xs text-gray-300 dark:group-hover:text-gray-300 group-hover:text-neutral-500 mb-2">Licencias</p>
      <div class="text-3xl text-gray-100 dark:group-hover:text-gray-100 group-hover:text-black font-semibold"><?php echo e($licensesCount); ?></div>
      <div class="mt-3 flex gap-2 text-xs">
        <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">AC: <?php echo e($byStatus['active']); ?></span>
        <span class="px-2 py-0.5 rounded bg-amber-100 text-amber-800">PD: <?php echo e($byStatus['pending']); ?></span>
        <span class="px-2 py-0.5 rounded bg-rose-100 text-rose-800">VC: <?php echo e($byStatus['expired']); ?></span>
      </div>
    </div>

    <div class="relative overflow-hidden rounded-lg group hover:shadow shadow-[#31353d] dark:shadow-[#4a4e58] bg-gradient-to-t dark:bg-gradient-to-b from-[#6fa31c] to-[#123338] hover:bg-none transition ease-in-out duration-300 p-5">
      <p class="text-xs text-gray-300 dark:group-hover:text-gray-300 group-hover:text-neutral-500 mb-2">Próximas a vencer</p>
      <div class="text-3xl text-gray-100 dark:group-hover:text-gray-100 group-hover:text-black font-semibold"><?php echo e($expiringSoonCount); ?></div>
      <p class="mt-1 text-xs text-gray-300 group-hover:text-neutral-500">en <?php echo e($soonDays); ?> días</p>
    </div>
  </div>

  
  <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
    <div class="p-5 flex items-center justify-between">
      <h2 class="font-semibold">Licencias próximas a vencer</h2>
      <div class="flex items-center gap-2 text-sm">
        <span class="text-neutral-500">Rango:</span>
        <span class="px-2 py-0.5 rounded bg-neutral-100 dark:bg-neutral-800"><?php echo e($soonDays); ?> días</span>
        
      </div>
    </div>

    <div class="overflow-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-neutral-100 dark:bg-neutral-900/30 text-left">
          <tr>
            <th class="p-3">Doctor</th>
            <th class="p-3">Estado</th>
            <th class="p-3">Expira</th>
            <th class="p-3">Status</th>
            <th class="p-3 w-28">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $expiringSoon; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="hover:bg-neutral-100 dark:hover:bg-neutral-900/20">
              <td class="p-3 whitespace-nowrap">
                <?php echo e($l->doctor?->user?->name ?? '—'); ?>

              </td>
              <td class="p-3 whitespace-nowrap">
                <?php echo e($l->state?->name); ?> (<?php echo e($l->state?->code); ?>)
              </td>
              <td class="p-3 whitespace-nowrap">
                <?php echo e(optional($l->expiration_date)->toDateString() ?? '—'); ?>

              </td>
              <td class="p-3">
                <?php
                  $badge = [
                    'active' => 'bg-emerald-100 text-emerald-800',
                    'pending'=> 'bg-amber-100 text-amber-800',
                    'expired'=> 'bg-rose-100 text-rose-800'
                  ][$l->status] ?? 'bg-neutral-100 text-neutral-800';
                ?>
                <span class="px-2 py-0.5 rounded text-xs <?php echo e($badge); ?>"><?php echo e(ucfirst($l->status)); ?></span>
              </td>
              <td class="p-3 text-right">
                  <a href="<?php echo e(route('licenses.edit', $l)); ?>" class="flex items-center space-x-1 text-blue-800 hover:text-blue-800/70 dark:text-white text-xs">
                      <?php if (isset($component)) { $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.index','data' => ['name' => 'pencil-square','class' => 'h-4 w-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'pencil-square','class' => 'h-4 w-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2)): ?>
<?php $attributes = $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2; ?>
<?php unset($__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2)): ?>
<?php $component = $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2; ?>
<?php unset($__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2); ?>
<?php endif; ?>
                      <span>Editar</span>
                  </a>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="5" class="p-6 text-center text-neutral-500">
                No hay licencias por vencer en los próximos <?php echo e($soonDays); ?> días.
              </td>
            </tr>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php /**PATH C:\Users\EOchoa\Escritorio\Kiwimap\resources\views/livewire/dashboard/metrics.blade.php ENDPATH**/ ?>