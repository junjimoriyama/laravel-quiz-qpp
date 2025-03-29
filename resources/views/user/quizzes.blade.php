<x-user-layout>

    <section
        class="p-3 flex flex-col items-center justify-center gap-3 text-white min-h-[calc(100vh-var(--header-height))]">
        <h1>{{$currentQuizIndex}}問目のクイズ</h1>

        <h2 class="p-3">{{ $quiz['question'] }}</h2>

        <div class="px-10 sm:px-5 p-5 w-full max-w-[1024px]">
            <ul class="hidden sm:flex justify-center font-bold border-b">
                <li class="w-12 text-center mb-2">番号</li>
                <li class="w-20 text-center mb-2">正解選択</li>
                <li class="flex-1 text-center mb-2">選択肢</li>
            </ul>

            {{-- どのクイズか判別するために送る --}}
            <form method="POST"
                action="{{ route('user.levels.quizzes.answer', [
                    'level' => $level,
                ]) }}"
                class="mb-5">
                @csrf
                <input type="hidden" name="quizId" value="{{ $quiz['id'] }}">
                @foreach ($quiz['options'] as $index => $option)
                    <ul
                        class="relative flex-col flex sm:flex-row items-center border-b py-2 {{ $loop->last ? 'mb-8' : '' }}">
                        <li class="sm:w-32 flex gap-3 mb-3 sm:mb-0">
                            <span class="sm:w-12 text-center">{{ $index + 1 }}</span>
                            <span class="sm:w-20 text-center flex justify-center  items-center">
                                <input class="scale-125" type="radio" name="optionId" value="{{ $option['id'] }}" required>
                            </span>
                        </li>
                        <li class="flex-1 text-center ml-5 sm:ml-0">{{ $option['content'] }}</li>
                    </ul>
                @endforeach

                <button type="submit"
                class="flex ml-auto bg-white text-blue-900 px-5 py-1 rounded transition duration-300 hover:opacity-50">解答する
                </button>
            </form>
        </div>
    </section>
</x-user-layout>
