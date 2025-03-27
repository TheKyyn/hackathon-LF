@props(['type' => 'primary', 'icon' => null])

@php
    $colorClasses = [
        'primary' => 'bg-primary-100 text-primary-800',
        'secondary' => 'bg-secondary-100 text-secondary-800',
        'success' => 'bg-success-100 text-success-800',
        'danger' => 'bg-danger-100 text-danger-800',
        'dark' => 'bg-dark-100 text-dark-800',
    ][$type] ?? 'bg-dark-100 text-dark-800';
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $colorClasses]) }}>
    @if($icon)
        <x-icon name="{{ $icon }}" class="w-3 h-3 mr-1" />
    @endif
    {{ $slot }}
</span>
