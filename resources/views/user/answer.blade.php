<x-user-layout>

    <section
        class="p-3 flex flex-col items-center justify-center gap-10 text-white min-h-[calc(100vh-var(--header-height))] h-full">
        <h1>クイズの結果は{{ $result ? '正解' : '不正解' }}</h1>

        <h2 class="p-3">{{ $quiz['question'] }}</h2>

        <div class="px-10 sm:px-5 p-5 w-full max-w-[1024px]">
            <ul class="hidden sm:flex justify-center font-bold border-b">
                <li class="w-12 text-center mb-2">番号</li>
                <li class="w-20 text-center mb-2">正解選択</li>
                <li class="flex-1 text-center mb-2">選択肢</li>
            </ul>


                {{-- どのクイズか判別するために送る --}}
                <input type="hidden" name="quizId" value="{{ $quiz['id'] }}">
                @foreach ($quiz['options'] as $index => $option)
                    <ul
                        class="relative flex-col flex sm:flex-row items-center border-b py-2 {{ $loop->last ? 'mb-8' : '' }}">
                        <li class="sm:w-32 flex gap-3 mb-3 sm:mb-0">
                            <span class="sm:w-12 text-center">{{ $index + 1 }}</span>
                            <span class="sm:w-20 text-center">
                                <input class="scale-125" type="radio" name="optionId" value="{{ $option['id'] }}">
                            </span>
                        </li>
                        <li class="flex-1 text-center ml-5 sm:ml-0">{{ $option['content'] }}</li>
                    </ul>
                @endforeach

                <button
                    class="flex ml-auto bg-yellow-600 text-white px-5 py-1 rounded transition duration-300 hover:opacity-50">次の問題へ
                </button>
        </div>
    </section>
</x-user-layout>
