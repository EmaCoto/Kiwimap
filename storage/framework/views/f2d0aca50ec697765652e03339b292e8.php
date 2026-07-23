<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => __('measurement_converter')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('measurement_converter'))]); ?>
    <div class="flex h-full w-full flex-1 flex-col gap-8 p-6 bg-[#fcfcfc] dark:bg-[#0d1516] rounded-3xl font-sans text-white transition-colors duration-300">

    
    <div class="flex flex-col md:flex-row justify-between items-end gap-6 px-2">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <span class="h-5 w-1 bg-[#351d5b] rounded-full"></span>
                <h1 class="text-3xl font-black text-[#123338] dark:text-white tracking-tighter uppercase italic"><?php echo e(__('Precision Converter')); ?></h1>
            </div>
            <p class="text-[10px] font-black text-[#02a676] uppercase tracking-[0.5em] ml-3"><?php echo e(__('System Metrics / Unit Analysis')); ?></p>
        </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="relative group p-8 rounded-lg bg-white dark:bg-[#123338]/30 border border-gray-100 dark:border-white/5 shadow-[0_15px_35px_-15px_rgba(0,0,0,0.05)] transition-all duration-300">
            <div class="relative z-10 flex flex-col items-start h-full">
                <p class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-4"><?php echo e(__('Length (Metric to Imperial)')); ?></p>

                <div class="w-full space-y-4">
                    <div>
                        <label class="text-[9px] font-black uppercase tracking-widest text-[#02a676] mb-1 block"><?php echo e(__('Meters (m)')); ?></label>
                        <input type="number" id="inputMetros" placeholder="0.00" step="0.01"
                        class="w-full bg-gray-50 dark:bg-[#123338] border-none text-4xl font-black italic tracking-tighter text-[#123338] dark:text-white focus:ring-2 focus:ring-[#351d5b] rounded-xl p-4 transition-all"
                        oninput="convertirLongitud()">
                    </div>

                    <div class="flex flex-col gap-4 mt-6">
                        <div class="flex justify-between items-end border-b border-gray-100 dark:border-white/5 pb-2">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest"><?php echo e(__('Feet (ft)')); ?></p>
                        <div id="resPies" class="text-5xl font-black italic tracking-tighter text-[#123338] dark:text-white">0.00</div>
                        </div>
                        <div class="flex justify-between items-end">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest"><?php echo e(__('Inches (in)')); ?></p>
                        <div id="resPulgadas" class="text-5xl font-black italic tracking-tighter text-[#6fa31c] dark:text-white">0.00</div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex items-center gap-2">
                    <div class="h-1 w-8 rounded-full bg-[#351d5b]"></div>
                    <p class="text-[9px] font-black text-gray-500 dark:text-gray-100 uppercase tracking-[0.2em]"><?php echo e(__('High Fidelity Conversion')); ?></p>
                </div>
            </div>
        </div>

        <div class="relative group p-8 rounded-lg bg-white dark:bg-[#123338]/30 border border-gray-100 dark:border-white/5 shadow-[0_15px_35px_-15px_rgba(0,0,0,0.05)] transition-all duration-300">
            <div class="relative z-10 flex flex-col items-start h-full">
                <p class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-4"><?php echo e(__('Mass (Kilograms to Pounds)')); ?></p>

                <div class="w-full space-y-4">
                    <div>
                        <label class="text-[9px] font-black uppercase tracking-widest text-[#f56e2a] mb-1 block"><?php echo e(__('Kilograms (kg)')); ?></label>
                        <input type="number" id="inputKilos" placeholder="0.00" step="0.01"
                        class="w-full bg-gray-50 dark:bg-[#123338] border-none text-4xl font-black italic tracking-tighter text-[#123338] dark:text-white focus:ring-2 focus:ring-[#c93d00] rounded-xl p-4 transition-all"
                        oninput="convertirPeso()">
                    </div>

                    <div class="mt-6">
                        <p class="text-[10px] font-black text-gray-400 uppercase mb-1 tracking-widest"><?php echo e(__('Pounds (lb)')); ?></p>
                        <div id="resLibras" class="text-7xl font-black italic tracking-tighter text-[#123338] dark:text-white transition-transform group-hover:translate-x-2">0.00</div>
                    </div>
                </div>

                <div class="mt-8 flex items-center gap-2">
                    <div class="h-1 w-8 rounded-full bg-[#c93d00]"></div>
                    <p class="text-[9px] font-black text-gray-500 dark:text-gray-100 uppercase tracking-[0.2em]"><?php echo e(__('Constant: 2.20462 lb/kg')); ?></p>
                </div>
            </div>
        </div>

    </div>

    
    <div class="bg-white dark:bg-[#123338]/10 rounded-lg border border-gray-100 dark:border-white/5 p-4 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <div class="h-2 w-2 rounded-full bg-[#02a676] animate-pulse shadow-[0_0_8px_#02a676]"></div>
            <h2 class="text-[10px] font-black uppercase tracking-widest italic text-gray-400 dark:text-white"><?php echo e(__('Active Processing Engine')); ?></h2>
        </div>
    </div>
    </div>

    <script>
    function convertirLongitud() {
        const metros = document.getElementById('inputMetros').value;
        const resPies = document.getElementById('resPies');
        const resPulgadas = document.getElementById('resPulgadas');

        if (metros === '' || metros < 0) {
        resPies.innerText = '0.00';
        resPulgadas.innerText = '0.00';
        return;
        }

        // 1 meter = 3.28084 feet
        const feetTotal = (metros * 3.28084).toFixed(2);
        // 1 meter = 39.3701 inches
        const inchesTotal = (metros * 39.3701).toFixed(2);

        resPies.innerText = feetTotal;
        resPulgadas.innerText = inchesTotal;
    }

    function convertirPeso() {
        const kilos = document.getElementById('inputKilos').value;
        const resLibras = document.getElementById('resLibras');

        if (kilos === '' || kilos < 0) {
        resLibras.innerText = '0.00';
        return;
        }

        const libras = (kilos * 2.20462).toFixed(2);
        resLibras.innerText = libras;
    }
    </script>
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
<?php /**PATH C:\Users\EOCHOA\Desktop\Kiwimap\resources\views\measurement_converter.blade.php ENDPATH**/ ?>