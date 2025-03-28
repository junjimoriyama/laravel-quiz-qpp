<x-user-layout>
    <section class="flex flex-col items-center justify-center text-white min-h-[calc(100vh-var(--header-height))] px-4">
        <h1 class="text-3xl font-bold mb-6">レコード</h1>

        <p>{{ $recordsMaxCount }}</p>

        <ul class="flex">
            <li class="flex flex-col">
                <span>回数</span>
                @for ($i = 0; $i < $recordsMaxCount; $i++)
                    <span>{{ $i + 1 }}回目</span>
                @endfor
            </li>

            {{-- 初級、中級、上級に分ける --}}
            @foreach ($levelsArray as $levelId => $levelName)
                <li class="flex flex-col">
                    @php
                        // レベル別に並べ直す
                        $recordByLevel = $records->where('level_id', $levelId)->values();
                    @endphp
                    <span>{{ $levelName }}</span>
                    @for ($i = 0; $i < $recordsMaxCount; $i++)
                        <span>{{ $recordByLevel[$i]->score }}</span>
                    @endfor

            </li>
            @endforeach

        </ul>



    </section>
</x-user-layout>



{{-- @php
    $scoresA = collect($records)->filter(fn($r) => $r['type'] === 'A');
    $scoresB = collect($records)->filter(fn($r) => $r['type'] === 'B');
    $scoresC = collect($records)->filter(fn($r) => $r['type'] === 'C');
@endphp

<h2>タイプA</h2>
@foreach ($scoresA as $score)
    <p>{{ $score['point'] }}</p>
@endforeach

<h2>タイプB</h2>
@foreach ($scoresB as $score)
    <p>{{ $score['point'] }}</p>
@endforeach

<h2>タイプC</h2>
@foreach ($scoresC as $score)
    <p>{{ $score['point'] }}</p>
@endforeach --}}


{{-- <x-user-layout>
    <section class="flex flex-col items-center justify-center text-white min-h-[calc(100vh-var(--header-height))] px-4">
        <h1 class="text-3xl font-bold mb-6">レコード</h1>

        @php
            $maxCount = $records->groupBy('level_id')->map->count()->max();
        @endphp

        <ul class="flex gap-8 text-xl font-light">
            <li class="flex flex-col items-center w-24 text-center">
                <div class="font-semibold mb-2">回数</div>
                @for ($i = 0; $i < $maxCount; $i++)
                    <div class="py-1">{{ $i + 1 }}回目</div>
                @endfor
            </li>

            @foreach ($levelsArray as $levelId => $levelName)
                @php
                    $recordsByLevel = $records->where('level_id', $levelId)->values();
                @endphp
                <li class="flex flex-col items-center w-24 text-center">
                    <div class="font-semibold mb-2">{{ $levelName }}</div>
                    @for ($i = 0; $i < $maxCount; $i++)
                        <div class="py-1">
                            @php
                            $record = $recordsByLevel[$i] ?? null;
                        @endphp

                        {{ $record ? $record->score . '点' : 'ー' }}

                        </div>
                    @endfor
                </li>
            @endforeach
        </ul>
    </section>
</x-user-layout> --}}
