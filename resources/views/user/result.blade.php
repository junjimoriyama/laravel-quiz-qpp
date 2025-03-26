@php
    $percentage = (int)round(($quizzesCount / $quizzesCount) * 100);
@endphp

<x-user-layout>
    <section
        class="p-3 flex flex-col items-center justify-center gap-3 text-white min-h-[calc(100vh-var(--header-height))] h-full">
        <h1 class="text-4xl">結果発表</h1>
        <div>正解数は
            <span class="mx-5 text-4xl">{{ $quizzesCount }}/{{ $quizzesCount }}</span>
        </div>
        <div>正解率は
            @if ($percentage < 50)
            <span class="mx-5 text-4xl text-red-500">{{ $percentage }}%</span>
            @elseif ($percentage > 50 && $percentage < 100)
            <span class="mx-5 text-4xl text-green-500">{{ $percentage }}%</span>
            @elseif ($percentage == 100)
            <span class="mx-5 text-4xl text-yellow-500">{{ $percentage }}%</span>
            @endif
        </div>
    </section>

</x-user-layout>
