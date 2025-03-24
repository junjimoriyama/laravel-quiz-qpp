<x-user-layout>
    <section
        class="flex flex-col items-center justify-center gap-10 text-white min-h-[calc(100vh-var(--header-height))]">

        @if ($quizzesCount > 0)
            <p class="text-3xl">全部で10問出題されます。</p>
            <p class="text-3xl">{{ $levelModel->label }}クイズを始める。</p>
            <button onclick="location.href='{{ route('user.levels.quizzes', ['level' => $levelModel->key]) }}'"
                class="px-4 py-2 rounded-md text-3xl bg-white text-blue-900 transition duration-300 hover:opacity-50">スタート
            </button>
        @else
            <p>クイズはまだ登録されていません。</p>
        @endif
    </section>
</x-user-layout>
