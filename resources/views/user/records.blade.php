<x-user-layout>
    <section
        class="flex flex-col items-center justify-center text-white min-h-[calc(100vh-var(--header-height))] px-4 bg-blue-900">
        <h1 class="text-2xl font-bold mb-8 tracking-wide">{{ $user->name }}さんのレコード一覧</h1>

        {{-- レコードがあれば --}}
        @if ( $recordsMaxCount > 0)
        <ul class="flex gap-8 text-lg font-light bg-white/10 p-6 rounded-2xl shadow-xl backdrop-blur-md mb-5">
            {{-- 回数列 --}}
            <li class="flex flex-col items-center w-24 text-center">
                <div class="font-semibold mb-2 text-slate-300">回数</div>
                {{-- 挑戦したクイズの数(最大の件数) --}}
                @for ($i = 0; $i < $recordsMaxCount; $i++)
                    <div class="py-1 text-slate-200">{{ $i + 1 }}回目</div>
                @endfor
            </li>

            {{-- 各レベル列 --}}
            @foreach ($levelsArray as $levelId => $levelName)
                @php
                    // 指定レベルのレコードだけを取り出し、インデックスを0から振り直す
                    $recordsByLevel = $records->where('level_id', $levelId)->values();
                @endphp
                <li class="flex flex-col items-center w-24 text-center">
                    <div class="font-semibold mb-2 text-yellow-500">{{ $levelName }}</div>
                    @for ($i = 0; $i < $recordsMaxCount; $i++)
                        @php
                            //  i番目のレコードが存在すれば取得。なければnullを入れる(nullはエラー回避)
                            $record = $recordsByLevel[$i] ?? null;
                        @endphp
                        <div class="py-1 text-white">
                            {{ $record ? $record->score . '点' : 'ー' }}
                        </div>
                    @endfor
                </li>
            @endforeach
        </ul>
        {{-- レコードがなければ --}}
        @else
            <div>表示できる結果はありません</div>
        @endif
        {{-- topに戻るボタン --}}
        <button type="button" onclick="location.href='{{ route('top') }}'"
            class="flex bg-white text-blue-900 px-5 py-1 rounded mb-10 transition duration-300 hover:opacity-50">戻る
        </button>
    </section>
</x-user-layout>
