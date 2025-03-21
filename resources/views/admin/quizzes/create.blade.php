<x-admin-layout>
    <section class="text-gray-600 body-font relative">
        <div class="flex flex-col items-center sm:p-5">
            <div class="flex flex-col text-center w-full mb-12">
                <h1 class="mt-10 text-2xl font-medium text-white sm:text-3xl ">
                    {{ $level->label }}クイズ新規登録
                </h1>
            </div>

            @if(session('error'))
                <div class="text-red-500">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.quizzes.store', ['level' => $level->key])}}" class="text-white text-2xl w-full max-w-7xl">
                @csrf
                {{-- 問題文 --}}
                <div class="flex flex-col items-center gap-3 mb-10">
                    <label class="text-xl" for="question">問題文</label>
                    <textarea class="w-2/3 min-w-[300px] h-[100px] mx-auto text-blue-900" id="question" name="question">{{ old('question') }}</textarea>
                    {{-- エラー文 --}}
                    @error('question')
                        <div class="text-red-700">{{ $message }}</div>
                    @enderror
                </div>
                {{-- 解説 --}}
                <div class="flex flex-col items-center gap-3 mb-10">
                    <label class="text-xl" for="solution">解説</label>
                    <textarea class="w-2/3 min-w-[300px] h-[100px] mx-auto text-blue-900" id="solution" name="solution">{{ old('solution') }}</textarea>
                    {{-- エラー文 --}}
                    @error('solution')
                        <div class="text-red-700">{{ $message }}</div>
                    @enderror
                </div>

                {{-- 選択肢 --}}
                @for ($i = 1; $i <= 4; $i++)
                    <div class="flex flex-col gap-3 mb-4 w-2/3 min-w-[300px] mx-auto">
                        <label class="text-xl text-center" for="solution">選択肢{{ $i }}</label>

                        {{-- 選択肢入力 --}}
                        <input class="w-full h-[50px] text-blue-900 p-2" id="content" name="content[]">

                        {{-- ラジオボタンも同じ左端に揃う --}}
                        <div class="flex items-center gap-2 justify-start">
                            {{--  correct_answerという名前でチェックした番号のみvalueで送付　--}}
                            <input class="accent-red-500 w-5 h-5" id="correct{{ $i }}" type="radio"
                            name="correct_answer" value="{{ $i }}">
                            <label  class="text-left text-base">正解</label>
                        </div>
                    </div>
                @endfor

                <button type="submit"
                    class="flex mx-auto mt-10 bg-yellow-600 text-white px-5 py-1 rounded mb-10 transition duration-300 hover:opacity-50">登録
                </button>
            </form>
        </div>
    </section>
</x-admin-layout>
