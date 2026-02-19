<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="dark">
    <head>
        <?php echo $__env->make('partials.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <style>
            /* Canvas de fondo siempre detrás del contenido */
            #bgCanvas-login {
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
    </head>
    <body class="min-h-screen bg-white antialiased">
        <!-- Canvas de fondo -->
        <canvas id="bgCanvas-login"></canvas>
        <div class="bg-background flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-sm flex-col gap-2">
                <a href="<?php echo e(route('home')); ?>" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <span class="flex h-16 w-36 mb-1 items-center justify-center rounded-md">
                        <?php if (isset($component)) { $__componentOriginal7b17d80ff7900603fe9e5f0b453cc7c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b17d80ff7900603fe9e5f0b453cc7c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.app-logo','data' => ['class' => 'size-9 fill-current text-black']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-9 fill-current text-black']); ?>
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
                    </span>
                    <span class="sr-only"><?php echo e(config('app.name', 'Laravel')); ?></span>
                </a>
                <div class="flex flex-col gap-6">
                    <?php echo e($slot); ?>

                </div>
            </div>
        </div>
        <?php app('livewire')->forceAssetInjection(); ?>
<?php echo app('flux')->scripts(); ?>

        <script>
            const canvas = document.getElementById('bgCanvas-login');
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
    </body>
</html> <?php /**PATH C:\Users\EOchoa\Escritorio\Kiwimap\resources\views/components/layouts/auth/simple.blade.php ENDPATH**/ ?>