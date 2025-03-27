@props(['text', 'color' => '#013565', 'route' => '#', 'icons' => true])

<a href="{{ $route }}" class="h-14 md:h-15 px-8 py-2.5 bg-[{{ $color }}] rounded border border-[{{ $color }}] inline-flex justify-center items-center gap-3 hover:opacity-90 transition-opacity">
    @if($icons)
    <div class="w-6 h-6 relative">
        <div class="w-2 h-3 left-[5px] top-[6px] absolute bg-white"></div>
        <div class="w-2 h-3 left-[11px] top-[6px] absolute opacity-50 bg-white"></div>
    </div>
    @endif
    <div class="text-right text-white text-lg font-bold font-sans uppercase">{{ $text }}</div>
    @if($icons)
    <div class="w-6 h-6 relative rotate-180 origin-top-left">
        <div class="w-2 h-3 left-[11px] top-[6px] absolute bg-white"></div>
        <div class="w-2 h-3 left-[5px] top-[6px] absolute opacity-50 bg-white"></div>
    </div>
    @endif
</a>
