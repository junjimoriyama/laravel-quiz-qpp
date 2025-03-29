
<x-user-layout>
    <section
        class="p-3 flex flex-col items-center justify-center gap-3 text-white min-h-[calc(100vh-var(--header-height))] h-full">
        <h1 class="text-4xl">結果発表</h1>
        <div>正解数は
            <span class="mx-5 text-4xl">{{ $correctAnswerCount }}/{{ $quizzesCount }}</span>
        </div>
        <div>正解率は
            @if ($correctPercentage < 50)
            <span class="mx-5 text-4xl text-red-500">{{ $correctPercentage }}%</span>
            @elseif ($correctPercentage >= 50 && $correctPercentage < 100)
            <span class="mx-5 text-4xl text-green-500">{{ $correctPercentage }}%</span>
            @elseif ($correctPercentage == 100)
            <span class="mx-5 text-4xl text-yellow-500">{{ $correctPercentage }}%</span>
            @endif
        </div>
        <button
        onclick="location.href='{{ route('top') }}'"
        class="flex mt-5 bg-white text-blue-900 px-5 py-1 rounded transition duration-300 hover:opacity-50"
        >
        クイズに選択画面に戻る
    </button>
    </section>
</x-user-layout>
{{-- onclick="location.href='{{ route('admin.quizzes.show', $levelModel->key)}}'" --}}
