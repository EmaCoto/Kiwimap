<x-layouts.guest :title="__('Dashboard')">
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
                            @if (Route::has('login'))
                                <nav class="flex items-center justify-end gap-4">
                                    @auth
                                        <a href="{{ url('/dashboard') }}" class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-white dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal bg-linear-to-b from-[#31353d] to-[#351d5b]">Dashboard</a>
                                    @else
                                        <a href="{{ route('login') }}" class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-white dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal bg-linear-to-b from-[#31353d] to-[#351d5b]">Ingresar</a>
                                    @endauth
                                </nav>
                            @endif
                        </li>
                    </ul>
                </div>
                <div class="relative flex items-center lg:-ms-px -mb-px lg:mb-0 rounded-t-lg lg:rounded-t-none lg:rounded-e-lg! aspect-[335/376] lg:aspect-auto w-full lg:w-[438px] shrink-0 overflow-hidden">
                    <div>
                        <x-app-logo />
                    </div>
                </div>
            </main>
        </div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif


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
  
</x-layouts.guest>
