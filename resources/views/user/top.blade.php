<x-user-layout>
    <section class="flex flex-col items-center justify-center text-white min-h-[calc(100vh-var(--header-height))]">
        <h1 class="mb-10 text-xl sm:text-2xl">クイズのレベルを選択してください。</h1>
        <div class="flex gap-5 md:gap-10 text-2xl mb-10 md:text-4xl">
            {{-- {{ $levels }} --}}
            @foreach ($levels as $level)
                <button onclick="location.href='{{ route('user.levels', ['level' => $level->key]) }}'"
                    class="px-4 py-2 rounded-md bg-white text-blue-900 transition duration-300 hover:opacity-50">{{ $level->label }}
                </button>
            @endforeach

        </div>
        <button
        class="flex bg-yellow-600 text-white px-5 py-1 rounded transition duration-300 hover:opacity-50"
        onclick="location.href='{{ route('user.records') }}'"

        >これまでの結果を見る
        </button>
    </section>
</x-user-layout>
