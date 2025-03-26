@props(['name', 'class' => 'w-5 h-5'])

<img src="{{ asset('images/icons/icon-' . $name . '.svg') }}" {{ $attributes->merge(['class' => $class]) }}>
