<x-user-layout>
    <section class="flex flex-col items-center justify-center text-white min-h-[calc(100vh-var(--header-height))]">
        <h1 class="mb-10 text-xl sm:text-2xl md:text-3xl">クイズのレベルを選択してください。</h1>
        <div class="flex gap-5 md:gap-10 text-2xl md:text-4xl">
            {{-- {{ $levels }} --}}
            @foreach ($levels as $level)
                <button onclick="location.href='{{ route('user.levels', ['level' => $level->key]) }}'"
                    class="px-4 py-2 rounded-md bg-white text-blue-900 transition duration-300 hover:opacity-50">{{ $level->label }}
                </button>
            @endforeach
            {{-- <button --}}
            {{-- onclick="location.href='{{ route('admin.quizzes.show', 'mid') }}'" --}}
            {{-- class="px-4 py-2 rounded-md bg-white text-blue-900 transition duration-300 hover:opacity-50">中級</button>
            <button --}}
            {{-- onclick="location.href='{{ route('admin.quizzes.show', 'pro') }}'" --}}
            {{-- class="px-4 py-2 rounded-md bg-white text-blue-900 transition duration-300 hover:opacity-50">上級</button> --}}
        </div>
    </section>
</x-user-layout>


{{-- <button
onclick="location.href='{{ route('user.levels.quizzes', [ 'level' => $level->key ]) }}'"
class="px-4 py-2 rounded-md bg-white text-blue-900 transition duration-300 hover:opacity-50">{{ $level->label }}
</button> --}}
