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


{{-- クイズ表示 (quizzes メソッドの流れ)
セッションから結果配列（quizResultsArray）を取得する

まだ何も答えていない場合は null

そのレベルのクイズ一覧（選択肢付き）を取得する

もし初回（セッションが空）なら

クイズIDを全部取得してシャッフル

各クイズIDごとに { quizId: クイズのID, result: null } の形で配列を作る

その配列をセッションに保存

まだ答えていない（result が null の）クイズを探す

もし未回答のクイズがあれば

それが全体の何問目か（index）を計算

そのクイズの詳細情報を取得

クイズ画面を返す（view に渡す）

全部答え終わっていたら

正解数をカウント（result が true の数）

結果画面を返す（view に渡す）

🌟 解答処理 (answer メソッドの流れ)
リクエストからクイズIDと選択した選択肢IDを取得する

レベルから全クイズ・選択肢を取得して、該当クイズを特定する

そのクイズの選択肢から「正解」を探す

正解の選択肢と、選んだ選択肢が一致しているか判定

セッションから quizResultsArray を取得

解答したクイズの result を true または false で更新する

セッションに上書き保存

解答結果ページを返す（正解 or 不正解を渡す）

🌟 正誤判定 (isCorrectAnswer メソッドの流れ)
クイズの選択肢一覧から「正解の選択肢（is_correct = true）」を探す

その正解IDと、プレイヤーが選んだoptionIdを比べる

一致していれば true、違えば false を返す --}}
