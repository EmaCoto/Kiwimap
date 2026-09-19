<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => __('resources.title')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('resources.title'))]); ?>
    <div class="flex w-full flex-1 flex-col gap-8 rounded-3xl bg-[#fcfcfc] p-4 font-sans sm:p-6 lg:p-10 dark:bg-[#0d1516]">
        <header class="space-y-3 border-l-4 border-[#02a676] pl-4">
            <p class="text-xs font-bold tracking-widest text-[#02a676]">KiwiMEDSPA</p>
            <h1 class="text-3xl font-black text-[#123338] dark:text-white"><?php echo e(__('resources.title')); ?></h1>
            <p class="text-sm text-gray-600 dark:text-gray-300"><?php echo e(__('resources.intro')); ?></p>
        </header>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = config('resources'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="flex flex-col gap-6 rounded-2xl border border-gray-100 bg-white p-6 shadow-sm sm:p-8 dark:border-white/10 dark:bg-[#123338]/20">
                    <div class="flex items-center justify-between gap-4">
                        <div class="rounded-2xl bg-[#02a676]/10 p-4 text-[#02a676]">
                            <?php if (isset($component)) { $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.index','data' => ['name' => 'book-open-text','class' => 'h-8 w-8']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'book-open-text','class' => 'h-8 w-8']); ?>
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
                        </div>
                        <span class="rounded-lg bg-[#351d5b]/5 px-3 py-1 text-xs font-bold text-[#351d5b] dark:bg-white/10 dark:text-white"><?php echo e($document['format']); ?></span>
                    </div>
                    <h2 class="text-xl font-bold text-[#123338] dark:text-white"><?php echo e(__($document['title'])); ?></h2>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($document['format'] !== 'PDF'): ?>
                        <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-300"><?php echo e(__('resources.presentation_note')); ?></p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div class="mt-auto flex flex-wrap gap-3 pt-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($document['format'] === 'PDF'): ?>
                            <a href="<?php echo e(route('resources.file', $key)); ?>" target="_blank" rel="noopener noreferrer" class="rounded-xl bg-[#351d5b] px-5 py-3 text-sm font-bold text-white transition-colors hover:bg-[#123338] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#02a676]"><?php echo e(__('resources.view')); ?></a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <a href="<?php echo e(route('resources.file', ['resource' => $key, 'download' => 1])); ?>" class="rounded-xl bg-[#02a676] px-5 py-3 text-sm font-bold text-white transition-colors hover:bg-[#123338] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#02a676]"><?php echo e(__('resources.download')); ?></a>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php /**PATH C:\Users\EOCHOA\Desktop\Kiwimap\resources\views/resources.blade.php ENDPATH**/ ?>