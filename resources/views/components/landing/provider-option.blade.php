@props(['name', 'multiline' => false])

<div class="flex-1 p-6 md:p-8 bg-[#013565]/5 rounded-md border border-[#013565] flex justify-center items-center gap-2.5 hover:bg-[#013565]/10 transition-colors cursor-pointer">
    <div class="text-center {{ $multiline ? 'flex flex-col' : '' }}">
        <span class="text-[#013565] text-lg md:text-xl font-bold font-sans">
            {!! $name !!}
        </span>
    </div>
</div>
