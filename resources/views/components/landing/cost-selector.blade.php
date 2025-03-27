@props(['title' => 'De plus en plus de foyers paient moins de 30€/mois grâce à ces aides. Et vous, combien payez vous par mois ?'])

<div class="w-screen relative left-1/2 right-1/2 -mx-[50vw] bg-white py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-black text-xl md:text-2xl lg:text-3xl font-bold font-marianne mb-6">De plus en plus de foyers paient moins de {{ $cost ?? '30€' }}/mois grâce à ces aides. Et vous, combien payez vous par mois ?</h2>

        <div class="w-full flex flex-col justify-start items-start gap-6">
            <div class="w-full flex flex-wrap md:flex-nowrap gap-4">
                <a href="{{ route('form', ['cost' => 1]) }}" class="flex-1 p-[30px] bg-[#013565]/5 rounded-md outline outline-1 outline-offset-[-1px] outline-[#013565] flex justify-center items-center gap-2.5 hover:bg-[#013565]/10 transition-colors">
                    <div class="text-center">
                        <span class="text-[#013565] text-xl font-bold font-marianne">0 - 100€ </span>
                        <span class="text-[#013565] text-sm font-normal font-marianne">/mois</span>
                    </div>
                </a>

                <a href="{{ route('form', ['cost' => 2]) }}" class="flex-1 p-[30px] bg-[#013565]/5 rounded-md outline outline-1 outline-offset-[-1px] outline-[#013565] flex justify-center items-center gap-2.5 hover:bg-[#013565]/10 transition-colors">
                    <div class="text-center">
                        <span class="text-[#013565] text-xl font-bold font-marianne">100 - 200€ </span>
                        <span class="text-[#013565] text-sm font-normal font-marianne">/mois</span>
                    </div>
                </a>

                <a href="{{ route('form', ['cost' => 3]) }}" class="flex-1 p-[30px] bg-[#013565]/5 rounded-md outline outline-1 outline-offset-[-1px] outline-[#013565] flex justify-center items-center gap-2.5 hover:bg-[#013565]/10 transition-colors">
                    <div class="text-center">
                        <span class="text-[#013565] text-xl font-bold font-marianne">200 - 300€ </span>
                        <span class="text-[#013565] text-sm font-normal font-marianne">/mois</span>
                    </div>
                </a>

                <a href="{{ route('form', ['cost' => 4]) }}" class="flex-1 p-[30px] bg-[#013565]/5 rounded-md outline outline-1 outline-offset-[-1px] outline-[#013565] flex justify-center items-center gap-2.5 hover:bg-[#013565]/10 transition-colors">
                    <div class="text-center">
                        <span class="text-[#013565] text-xl font-bold font-marianne">300€ et + </span>
                        <span class="text-[#013565] text-sm font-normal font-marianne">/mois</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
