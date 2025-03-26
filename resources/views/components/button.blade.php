@props(['variant' => 'primary', 'icon' => null, 'iconPosition' => 'left'])

@php
    $variantClasses = [
        'primary' => 'bg-primary-600 hover:bg-primary-700 text-white',
        'secondary' => 'bg-secondary-600 hover:bg-secondary-700 text-white',
        'outline-primary' => 'border border-primary-600 text-primary-600 hover:bg-primary-50',
        'outline-secondary' => 'border border-secondary-600 text-secondary-600 hover:bg-secondary-50',
        'light' => 'bg-white border border-dark-200 text-dark-700 hover:bg-dark-50',
        'dark' => 'bg-dark-800 hover:bg-dark-900 text-white',
    ][$variant] ?? 'bg-primary-600 hover:bg-primary-700 text-white';
@endphp

<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 rounded-lg font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors ' . $variantClasses]) }}>
    @if($icon && $iconPosition === 'left')
        <x-icon name="{{ $icon }}" class="w-5 h-5 mr-2" />
    @endif

    {{ $slot }}

    @if($icon && $iconPosition === 'right')
        <x-icon name="{{ $icon }}" class="w-5 h-5 ml-2" />
    @endif
</button>
