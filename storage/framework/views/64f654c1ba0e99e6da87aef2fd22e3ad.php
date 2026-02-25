

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'variant' => 'outline',
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'variant' => 'outline',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    if ($variant === 'solid') {
        throw new \Exception('The "solid" variant is not supported in Lucide.');
    }

    $classes = Flux::classes('shrink-0')->add(
        match ($variant) {
            'outline' => '[:where(&)]:size-6',
            'solid' => '[:where(&)]:size-6',
            'mini' => '[:where(&)]:size-5',
            'micro' => '[:where(&)]:size-4',
        },
    );

    $strokeWidth = match ($variant) {
        'outline' => 2,
        'mini' => 2.25,
        'micro' => 2.5,
    };
?>




<svg 
    <?php echo e($attributes->class($classes)); ?>

    xmlns="http://www.w3.org/2000/svg" 
    width="24" 
    height="24" 
    viewBox="0 0 24 24" 
    fill="none" 
    stroke="currentColor" 
    stroke-width="2" 
    stroke-linecap="round" 
    stroke-linejoin="round" 
    class="lucide lucide-user-round-cog-icon lucide-user-round-cog"
>
    <path d="m14.305 19.53.923-.382"/>
    <path d="m15.228 16.852-.923-.383"/>
    <path d="m16.852 15.228-.383-.923"/>
    <path d="m16.852 20.772-.383.924"/>
    <path d="m19.148 15.228.383-.923"/>
    <path d="m19.53 21.696-.382-.924"/>
    <path d="M2 21a8 8 0 0 1 10.434-7.62"/>
    <path d="m20.772 16.852.924-.383"/>
    <path d="m20.772 19.148.924.383"/>
    <circle cx="10" cy="8" r="5"/>
    <circle cx="18" cy="18" r="3"/>
</svg><?php /**PATH /var/www/resources/views/flux/icon/group-user.blade.php ENDPATH**/ ?>