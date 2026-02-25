<?php if (isset($component)) { $__componentOriginal1e6834b7596effc838ab3adb1475b477 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1e6834b7596effc838ab3adb1475b477 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.guest','data' => ['title' => __('Dashboard')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.guest'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Dashboard'))]); ?>
        <style>
            /* Canvas de fondo siempre detrás del contenido */
            #bgCanvas {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: none; /* no bloquea clics */
                z-index: -1;          /* por debajo de todo */
                background: transparent;
            }
        </style>

        <!-- Canvas de fondo -->
        <canvas id="bgCanvas"></canvas>
        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
                <div class="text-[13px] leading-[20px] flex-1 p-6 pb-12 lg:p-20  rounded-es-lg rounded-ee-lg lg:rounded-ss-lg lg:rounded-ee-none">
                    <h1 class="font-bold">Empecemos</h1>
                    <p class="my-4">Kiwimap cuenta con un ecosistema diseñado para la gestión de licencias médicas y la operación de nuestra clínica digital. <br>Te sugerimos empezar con lo siguiente.</p>
                    
                    <ul class="flex text-sm leading-normal">
                        <li>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Route::has('login')): ?>
                                <nav class="flex items-center justify-end gap-4">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                                        <a href="<?php echo e(url('/dashboard')); ?>" class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-white dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal bg-linear-to-b from-[#31353d] to-[#351d5b]">Dashboard</a>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('login')); ?>" class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-white dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal bg-linear-to-b from-[#31353d] to-[#351d5b]">Ingresar</a>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </nav>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </li>
                    </ul>
                </div>
                <div class="relative flex items-center lg:-ms-px -mb-px lg:mb-0 rounded-t-lg lg:rounded-t-none lg:rounded-e-lg! aspect-[335/376] lg:aspect-auto w-full lg:w-[438px] shrink-0 overflow-hidden">
                    <div>
                        <?php if (isset($component)) { $__componentOriginal7b17d80ff7900603fe9e5f0b453cc7c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b17d80ff7900603fe9e5f0b453cc7c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-logo','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7b17d80ff7900603fe9e5f0b453cc7c3)): ?>
<?php $attributes = $__attributesOriginal7b17d80ff7900603fe9e5f0b453cc7c3; ?>
<?php unset($__attributesOriginal7b17d80ff7900603fe9e5f0b453cc7c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7b17d80ff7900603fe9e5f0b453cc7c3)): ?>
<?php $component = $__componentOriginal7b17d80ff7900603fe9e5f0b453cc7c3; ?>
<?php unset($__componentOriginal7b17d80ff7900603fe9e5f0b453cc7c3); ?>
<?php endif; ?>
                    </div>
                </div>
            </main>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Route::has('login')): ?>
            <div class="h-14.5 hidden lg:block"></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


        <script>
            const canvas = document.getElementById('bgCanvas');
            const ctx = canvas.getContext('2d');

            // Ajustar tamaño al viewport
            function resize() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }
            window.addEventListener('resize', resize);
            resize();

            // Configuración
            const numBalls = 30;
            const balls = [];
            for (let i = 0; i < numBalls; i++) {
                balls.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                r: 3 + Math.random() * 3,
                vx: (Math.random() - 0.5) * 1.2,
                vy: (Math.random() - 0.5) * 1.2
                });
            }

            function draw() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                // Dibujar y mover bolitas
                balls.forEach(b => {
                b.x += b.vx;
                b.y += b.vy;
                // Rebote en bordes
                if (b.x < 0 || b.x > canvas.width) b.vx *= -1;
                if (b.y < 0 || b.y > canvas.height) b.vy *= -1;

                ctx.beginPath();
                ctx.fillStyle = 'rgba(120,120,120,0.4)';
                ctx.arc(b.x, b.y, b.r, 0, Math.PI * 2);
                ctx.fill();
                });

                requestAnimationFrame(draw);
            }
            draw();
        </script>
  
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1e6834b7596effc838ab3adb1475b477)): ?>
<?php $attributes = $__attributesOriginal1e6834b7596effc838ab3adb1475b477; ?>
<?php unset($__attributesOriginal1e6834b7596effc838ab3adb1475b477); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1e6834b7596effc838ab3adb1475b477)): ?>
<?php $component = $__componentOriginal1e6834b7596effc838ab3adb1475b477; ?>
<?php unset($__componentOriginal1e6834b7596effc838ab3adb1475b477); ?>
<?php endif; ?>
<?php /**PATH /var/www/resources/views/welcome.blade.php ENDPATH**/ ?>