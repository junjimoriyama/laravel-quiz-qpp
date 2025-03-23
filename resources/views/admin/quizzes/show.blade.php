@php
    use Illuminate\Support\Str;
@endphp

<x-admin-layout>
    <section class="flex flex-col items-center justify-center text-white min-h-[calc(100vh-var(--header-height))]">
        @if ($canResister)
            <button onclick="location.href='{{ route('admin.quizzes.create', ['level' => $level->key]) }}'"
                class="flex mx-auto mt-10 mb-12 md:mb-24 bg-yellow-600 text-white text-2xl px-5 py-1 rounded transition duration-300 hover:opacity-50">新規クイズ登録</button>
            </button>
        @else
            <p
                class="flex mx-auto mt-10  text-white px-5 py-1 rounded mb-10 transition duration-300 hover:opacity-50">
                登録の問題数は10までになります
            </p>
        @endif
            <h1 class="mb-10 text-2xl">{{ $level->label }}クイズ一覧</h1>


            {{-- <form action="" class=""> --}}

            <ul class="grid grid-cols-9 gap-4 text-white w-full max-w-7xl sm:grid-cols-9">
                <!-- ヘッダー -->
                <li class="font-bold text-center col-span-1 bg-white text-blue-900 rounded-sm hidden sm:block">番号</li>
                <li class="font-bold text-center col-span-6 bg-white text-blue-900 rounded-sm hidden sm:block">問題文</li>
                <li class="font-bold text-center col-span-2 bg-white text-blue-900 rounded-sm hidden sm:block">操作</li>


                @foreach ($quizzes as $quiz)
                    <!-- 番号 -->
                    <li class="bg-white rounded-sm md:bg-transparent text-blue-900 md:text-white text-center col-span-9 sm:col-span-1">{{ $loop->iteration }}問目</li>

                    <!-- 問題文 -->
                    <li class="text-center col-span-9 sm:col-span-6">
                        {{ Str::limit($quiz->question, 20) }}
                    </li>

                    <!-- 編集・削除（スマホ時だけ横並び） -->
                    <li class="col-span-9 sm:col-span-2 flex justify-center gap-4">
                        {{-- 編集ページに遷移 --}}
                        <button type="button"
                            onclick="location.href='{{ route('admin.quizzes.edit', [
                                'level' => $level->key,
                                'quiz' => $quiz->id,
                            ]) }}'"
                            class="bg-white text-blue-900 px-2 py-1 rounded">
                            編集
                        </button>
                        <form method="POST"
                            action="{{ route('admin.quizzes.destroy', [
                                'level' => $level,
                                'quiz' => $quiz->id,
                            ]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-white text-red-500 px-2 py-1 rounded">
                                削除
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>

            {{-- </form> --}}
    </section>
</x-admin-layout>









{{--
<form action="" class="">
    <ul class="grid grid-cols-9 sm:grid-cols-9 gap-4 w-full max-w-5xl text-white">
        <!-- ヘッダー -->
        <li class="font-bold text-center col-span-1">番号</li>
        <li class="font-bold text-center col-span-6">問題文</li>
        <li class="font-bold text-center col-span-1">編集</li>
        <li class="font-bold text-center col-span-1">削除</li>

        @for ($i = 0; $i < 10; $i++)
            <!-- 番号 -->
            <li class="text-center col-span-9 sm:col-span-1">{{ $i + 1 }}問目</li>

            <!-- 問題文 -->
            <li class="text-center col-span-9 sm:col-span-6">
                問題文問題文問題文問題文問題文問題文問題文{{ $i + 1 }}
            </li>

            <!-- 編集・削除（スマホ時だけ横並び） -->
            <li class="col-span-9 sm:col-span-2 flex justify-center gap-2">
                <button class="bg-white text-blue-900 px-2 py-1 rounded">編集</button>
                <button class="bg-white text-red-500 px-2 py-1 rounded">削除</button>
            </li>
        @endfor
    </ul>

</form> --}}
