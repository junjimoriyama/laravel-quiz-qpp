<x-user-layout>

    <section
        class="p-3 flex flex-col items-center justify-center gap-3 text-white min-h-[calc(100vh-var(--header-height))] h-full">
        <div class="flex items-center gap-3 text-2xl mb-5">クイズの結果は
            @if ($isCorrectAnswer)
                <p class="text-yellow-500 text-4xl">正解</p>
            @else
                <p class="text-red-500 text-4xl">不正解</p>
            @endif
        </div>
        <p class="p-3">問題文：{{ $quiz->question }}</p>
        <p class="mb-5">解説：{{ $quiz->solution }}</p>


        <div class="px-10 sm:px-5 p-5 w-full max-w-[1024px]">
            <ul class="hidden sm:flex justify-center font-bold border-b">
                <li class="w-12 text-center mb-2">番号</li>
                <li class="w-20 text-center mb-2">判定</li>
                <li class="flex-1 text-center mb-2">選択肢</li>
            </ul>

            {{-- どのクイズか判別するために送る --}}
            @foreach ($quiz->options as $index => $option)
                <ul
                    class="relative flex-col flex sm:flex-row items-center border-b py-2 {{ $loop->last ? 'mb-8' : '' }}">
                    <li class="sm:w-32 flex gap-3 mb-3 sm:mb-0">
                        <span class="sm:w-12 text-center">{{ $index + 1 }}</span>
                        @if ($option->is_correct === 1)
                            <span class="mx-auto text-yellow-600 text-4xl font-black">⚫︎</span>
                        @else
                            <span class="mx-auto text-red-500 text-4xl">×</span>
                        @endif
                    </li>
                    <li class="flex-1 text-center ml-5 sm:ml-0">{{ $option->content }}</li>
                </ul>
            @endforeach

            <button
                onclick="location.href='{{ route('user.levels.quizzes', [
                    'level' => $level,
                ]) }}'"
                class="flex ml-auto bg-white text-blue-900 px-5 py-1 rounded transition duration-300 hover:opacity-50">{{$remainingQuizCount !== 0 ? "次の問題へ" : "結果を表示"}}
            </button>
        </div>
    </section>

    {{-- <script>
        // 回答済みクイズのIDとメッセージを保存
        localStorage.setItem('answeredQuiz', '{{ $quiz->id }}');
        localStorage.setItem('answeredMessage', 'このクイズにはすでに回答済みです');
    </script> --}}
</x-user-layout>
