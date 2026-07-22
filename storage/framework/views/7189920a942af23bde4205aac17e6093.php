<div class="fixed bottom-6 right-6" >
    <?php ($current = app()->getLocale()); ?>
    <?php ($isEn = $current === 'en'); ?>
    <?php ($switchUrl = url('/lang')); ?>

    <label class="relative inline-flex items-center cursor-pointer">
        <input
            type="checkbox"
            class="sr-only peer"
            <?php if($isEn): echo 'checked'; endif; ?>
            onchange="
                if (this.dataset.loading === 'true') {
                    return;
                }

                this.dataset.loading = 'true';
                this.disabled = true;

                const locale = this.checked ? 'en' : 'es';
                const token = document.querySelector('meta[name=&quot;csrf-token&quot;]')?.content;

                fetch('<?php echo e($switchUrl); ?>/' + locale, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token ?? '',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                }).then((response) => {
                    if (! response.ok) {
                        throw new Error('Locale switch failed');
                    }

                    window.location.reload();
                }).catch(() => {
                    window.location.href = '<?php echo e($switchUrl); ?>/' + locale;
                });
            "
            aria-label="Switch language"
        >
        <div class="peer shadow-sm hover:scale-110 shadow-black dark:shadow-white  outline-none text-xs rounded-full after:duration-500 w-12 h-8 bg-[#123338] peer-focus:outline-none after:content-['ES'] after:absolute after:outline-none after:h-6 after:w-6 after:rounded-full after:bg-white after:top-1 after:left-1 after:flex after:justify-center after:items-center after:text-[#123338] after:font-bold peer-checked:after:translate-x-4 peer-checked:after:content-['EN'] peer-checked:after:border-white duration-300 transition ease-in-out"></div>
    </label>
</div>
<?php /**PATH C:\Users\EOCHOA\Desktop\Kiwimap\resources\views/components/language-button.blade.php ENDPATH**/ ?>