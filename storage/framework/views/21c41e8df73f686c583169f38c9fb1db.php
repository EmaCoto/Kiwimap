<div class="space-y-8 p-4">

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 4000)"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="flex items-center gap-3 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 shadow-sm"
        >
            <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span class="font-medium"><?php echo e(session('success')); ?></span>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="grid gap-8 lg:grid-cols-3">

        
        <div class="lg:col-span-1">
            <div class="sticky top-8 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-shadow hover:shadow-md">
                <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                    <h2 class="text-lg font-bold tracking-tight text-slate-900">Crear QR</h2>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Configuración y Generación</p>
                </div>

                <div
                    x-data="{
                        logoFile: null,
                        logoPreview: null,
                        uploading: false,
                        saving: false,

                        init() {
                            $wire.on('qr-saved', () => {
                                this.logoFile    = null
                                this.logoPreview = null
                                this.uploading   = false
                                this.saving      = false
                                this.$refs.fileInput.value = ''
                            })
                        },

                        handleFile(e) {
                            const file = e.target.files[0]
                            if (!file) return

                            if (file.type !== 'image/png') {
                                alert('Solo se permiten archivos PNG.')
                                e.target.value = ''
                                return
                            }
                            if (file.size > 2 * 1024 * 1024) {
                                alert('El archivo no puede superar 2 MB.')
                                e.target.value = ''
                                return
                            }

                            this.logoFile = file
                            const reader = new FileReader()
                            reader.onload = (ev) => this.logoPreview = ev.target.result
                            reader.readAsDataURL(file)
                        },

                        removeLogo() {
                            this.logoFile    = null
                            this.logoPreview = null
                            this.$refs.fileInput.value = ''
                        },

                        async submitForm() {
                            if (this.saving) return
                            this.saving = true

                            try {
                                if (this.logoFile) {
                                    this.uploading = true
                                    await new Promise((resolve, reject) => {
                                        $wire.upload(
                                            'logo',
                                            this.logoFile,
                                            () => { this.uploading = false; resolve() },
                                            () => { this.uploading = false; reject(new Error('Upload failed')) },
                                        )
                                    })
                                }
                                await $wire.save()
                            } catch (err) {
                                console.error('Error al guardar QR:', err)
                                this.saving = false
                            }
                        }
                    }"
                    class="p-6"
                >
                    <div class="space-y-5">

                        
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-700">Nombre del QR</label>
                            <input
                                type="text"
                                wire:model="name"
                                placeholder="Ej: Menú Principal"
                                class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2.5 text-sm transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:text-black"
                            >
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="mt-1.5 block text-xs font-medium text-rose-500"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-700">Tipo de Contenido</label>
                            <select
                                wire:model.live="type"
                                class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2.5 text-sm transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 dark:text-black"
                            >
                                <option value="text">Texto</option>
                                <option value="url">URL</option>
                                <option value="phone">Teléfono</option>
                                <option value="whatsapp">WhatsApp</option>
                                <option value="wifi">WiFi</option>
                            </select>
                        </div>

                        
                        <div class="rounded-xl border border-slate-100 bg-slate-50/30 p-4 dark:text-black">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type === 'text'): ?>
                                <div>
                                    <label class="mb-1.5 block text-xs font-bold uppercase text-slate-500">Texto</label>
                                    <textarea
                                        wire:model="text"
                                        rows="3"
                                        class="w-full rounded-lg border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500/10"
                                    ></textarea>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="mt-1 block text-xs text-rose-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type === 'url'): ?>
                                <div>
                                    <label class="mb-1.5 block text-xs font-bold uppercase text-slate-500">URL Destino</label>
                                    <input type="url" wire:model="url" placeholder="https://..." class="w-full rounded-lg border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500/10">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="mt-1 block text-xs text-rose-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type === 'phone'): ?>
                                <div>
                                    <label class="mb-1.5 block text-xs font-bold uppercase text-slate-500">Número</label>
                                    <input type="text" wire:model="phone" class="w-full rounded-lg border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500/10">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="mt-1 block text-xs text-rose-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type === 'whatsapp'): ?>
                                <div class="space-y-3">
                                    <div>
                                        <label class="mb-1.5 block text-xs font-bold uppercase text-slate-500">WhatsApp (con código de país)</label>
                                        <input type="text" wire:model="whatsapp" placeholder="573001234567" class="w-full rounded-lg border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500/10">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['whatsapp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="mt-1 block text-xs text-rose-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-xs font-bold uppercase text-slate-500">Mensaje predeterminado</label>
                                        <textarea wire:model="whatsapp_message" rows="2" class="w-full rounded-lg border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500/10"></textarea>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type === 'wifi'): ?>
                                <div class="space-y-3">
                                    <div>
                                        <label class="mb-1.5 block text-xs font-bold uppercase text-slate-500">Nombre de Red (SSID)</label>
                                        <input type="text" wire:model="wifi_ssid" class="w-full rounded-lg border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500/10">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['wifi_ssid'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="mt-1 block text-xs text-rose-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <label class="mb-1.5 block text-xs font-bold uppercase text-slate-500">Password</label>
                                            <input type="text" wire:model="wifi_password" class="w-full rounded-lg border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500/10">
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-xs font-bold uppercase text-slate-500">Seguridad</label>
                                            <select wire:model="wifi_security" class="w-full rounded-lg border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500/10">
                                                <option value="WPA">WPA/WPA2</option>
                                                <option value="WEP">WEP</option>
                                                <option value="nopass">Abierta</option>
                                            </select>
                                        </div>
                                    </div>
                                    <label class="flex items-center gap-2 py-1 text-sm font-medium text-slate-600">
                                        <input type="checkbox" wire:model="wifi_hidden" class="rounded border-slate-300 text-slate-900 focus:ring-blue-500/20">
                                        Red oculta
                                    </label>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold uppercase text-slate-500">Color QR</label>
                                <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white p-2">
                                    <input type="color" wire:model="foreground_color" class="h-8 w-12 cursor-pointer border-0 bg-transparent">
                                    <span class="text-xs font-mono text-slate-500"><?php echo e($foreground_color); ?></span>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold uppercase text-slate-500">Fondo</label>
                                <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white p-2">
                                    <input type="color" wire:model="background_color" class="h-8 w-12 cursor-pointer border-0 bg-transparent">
                                    <span class="text-xs font-mono text-slate-500"><?php echo e($background_color); ?></span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-700">Resolución</label>
                            <select wire:model="size" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2 text-sm dark:text-black">
                                <option value="400">Normal (400px)</option>
                                <option value="600">Alta (600px)</option>
                                <option value="1000">Ultra (1000px)</option>
                            </select>
                        </div>

                        
                        <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50/50 p-4 text-center">
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Logo Central (PNG)</label>

                            <input
                                x-ref="fileInput"
                                type="file"
                                accept="image/png"
                                x-on:change="handleFile($event)"
                                class="hidden"
                                id="logo-upload"
                            >
                            <label for="logo-upload" class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-white px-4 py-2 text-xs font-bold text-slate-700 shadow-sm border border-slate-200 hover:bg-slate-50 transition">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round"/></svg>
                                Seleccionar Logo
                            </label>

                            <template x-if="logoPreview">
                                <div class="mt-4 flex flex-col items-center gap-2">
                                    <div class="relative inline-block">
                                        <img :src="logoPreview" class="h-16 w-16 rounded-lg border bg-white object-contain p-1 shadow-sm">
                                        <button type="button" x-on:click="removeLogo()" class="absolute -right-2 -top-2 flex h-6 w-6 items-center justify-center rounded-full bg-rose-500 text-white shadow-lg hover:bg-rose-600 transition">
                                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/></svg>
                                        </button>
                                    </div>
                                    <span class="text-[10px] font-bold uppercase text-slate-400">Vista previa logo</span>
                                </div>
                            </template>
                        </div>

                        
                        <button
                            type="button"
                            x-on:click="submitForm()"
                            :disabled="saving"
                            class="relative flex w-full items-center justify-center overflow-hidden rounded-xl bg-slate-900 px-6 py-4 text-sm font-bold text-white shadow-xl transition active:scale-95 disabled:opacity-70"
                        >
                            <span x-show="!saving">Generar y Guardar QR</span>

                            <div x-show="saving" class="flex items-center gap-3">
                                <svg class="h-5 w-5 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                <span x-show="uploading">Subiendo archivos...</span>
                                <span x-show="!uploading">Procesando QR...</span>
                            </div>
                        </button>

                    </div>
                </div>
            </div>
        </div>

        
        <div class="lg:col-span-2">
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                <div class="border-b border-slate-100 bg-white px-6 py-5 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Mis Códigos QR</h2>
                        <p class="text-sm text-slate-500">Historial de códigos generados</p>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">
                        <?php echo e($qrs->total()); ?> registrados
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50 text-xs font-bold uppercase tracking-widest text-slate-400">
                                <th class="px-6 py-4">Imagen</th>
                                <th class="px-6 py-4">Información</th>
                                <th class="px-6 py-4 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $qrs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr wire:key="qr-<?php echo e($qr->id); ?>" class="group hover:bg-slate-50/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="relative h-20 w-20 shrink-0 overflow-hidden rounded-xl border border-slate-200 bg-white p-1.5 shadow-sm group-hover:scale-105 transition">
                                            <img
                                                src="<?php echo e(Storage::url($qr->qr_path)); ?>"
                                                alt="<?php echo e($qr->name); ?>"
                                                class="h-full w-full object-contain"
                                            >
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-900"><?php echo e($qr->name); ?></span>
                                            <div class="mt-1 flex items-center gap-2">
                                                <span class="rounded bg-slate-100 px-2 py-0.5 text-[10px] font-bold uppercase text-slate-600">
                                                    <?php echo e($qr->type); ?>

                                                </span>
                                                <span class="text-xs text-slate-400">
                                                    <?php echo e($qr->created_at->diffForHumans()); ?>

                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-2">
                                            <a href="<?php echo e(Storage::url($qr->qr_path)); ?>" target="_blank" class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 shadow-sm hover:bg-slate-50 hover:text-blue-600 transition" title="Ver original">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2"/></svg>
                                            </a>

                                            <button wire:click="download(<?php echo e($qr->id); ?>)" class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 shadow-sm hover:bg-slate-50 hover:text-emerald-600 transition disabled:opacity-30" title="Descargar">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </button>

                                            <button
                                                wire:click="delete(<?php echo e($qr->id); ?>)"
                                                wire:confirm="¿Seguro que quieres eliminar este QR?"
                                                class="flex h-9 w-9 items-center justify-center rounded-lg border border-rose-100 bg-rose-50/50 text-rose-500 shadow-sm hover:bg-rose-50 hover:text-rose-600 transition disabled:opacity-30" title="Borrar"
                                            >
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="3" class="py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="mb-4 rounded-full bg-slate-50 p-4">
                                                <svg class="h-10 w-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </div>
                                            <p class="text-base font-bold text-slate-900">Sin resultados</p>
                                            <p class="text-sm text-slate-400">Aún no has creado ningún código QR personalizado.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($qrs->hasPages()): ?>
                    <div class="border-t border-slate-100 bg-slate-50/30 px-6 py-4">
                        <?php echo e($qrs->links()); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

    </div>
</div><?php /**PATH C:\Users\EOCHOA\Desktop\Kiwimap\resources\views\livewire\qr\manager.blade.php ENDPATH**/ ?>