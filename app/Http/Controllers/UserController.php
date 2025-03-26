<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Quiz;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // トップページ表示
    public function top()
    {
        $levels = Level::all();

        return view('user.top', compact('levels'));
    }

    // レベル選択後のスタート画面表示（セッション初期化）
    public function levels($level)
    {
        // 過去の結果をクリア
        session()->forget('resultArray');

        $levelModel = Level::withCount('quizzes')->where('key', $level)->firstOrFail();

        return view('user.levels', [
            'levelModel' => $levelModel,
            'level' => $level,
            'quizzesCount' => $levelModel->quizzes_count
        ]);
    }

    // クイズ出題画面
    public function quizzes(Request $request, $level)
    {
        // セッションから回答結果取得
        $resultArray = session('resultArray');

        // レベルのクイズと選択肢を取得
        $levelModel = Level::with('quizzes.options')->where('key', $level)->firstOrFail();
        $quizzes = $levelModel->quizzes;

        // 初回のみセッションにクイズ一覧をセット（シャッフル）
        if (!$resultArray) {
            $quizIds = $quizzes->pluck('id')->toArray();
            shuffle($quizIds);

            $resultArray = array_map(fn($quizId) => [
                'quizId' => $quizId,
                'result' => null
            ], $quizIds);

            session(['resultArray' => $resultArray]);
        }

        // 未回答のクイズを取得
        $noAnswerQuiz = collect($resultArray)->filter(fn($item) => $item['result'] === null)->first();

        dump($noAnswerQuiz); // デバッグ確認用

        // 現在のクイズ番号を計算
        if ($noAnswerQuiz) {
            $currentQuizIndex = 0;
            foreach ($resultArray as $index => $result) {
                if ($result['quizId'] === $noAnswerQuiz['quizId']) {
                    $currentQuizIndex = $index + 1; // 配列は0スタート
                    break;
                }
            }
            // クイズの詳細情報取得
            $quiz = $quizzes->firstWhere('id', $noAnswerQuiz['quizId']);
        } else {
            // 全問回答済みなら結果画面へ
            return view('user.result', [
                'level' => $level,
                'resultArray' => $resultArray,
            ]);
        }

        // クイズ画面を表示
        return view('user.quizzes', [
            'level' => $level,
            'quiz' => $quiz,
            'currentQuizIndex' => $currentQuizIndex,
        ]);
    }

    // 解答送信処理
    public function answer(Request $request, $level)
    {
        // クイズIDと選択したオプションIDを取得
        $quizId = $request->quizId;
        $selectOptionId = $request->optionId;

        // クイズ取得
        $levelModel = Level::with('quizzes.options')->where('key', $level)->firstOrFail();
        $quizzes = $levelModel->quizzes;
        $quiz = $quizzes->firstWhere('id', $quizId);

        // 正解判定
        $quizOptions = $quiz->options->toArray();
        $isCorrectAnswer = $this->isCorrectAnswer($selectOptionId, $quizOptions);

        // セッションから回答配列取得
        $resultArray = session('resultArray', []);

        // 該当クイズの結果を更新
        foreach ($resultArray as $index => $result) {
            if ($result['quizId'] === (int)$quizId) {
                $resultArray[$index]['result'] = $isCorrectAnswer;
                break;
            }
        }

        // 更新した結果をセッション保存
        session(['resultArray' => $resultArray]);

        // 解答結果表示
        return view('user.answer', [
            'level' => $level,
            'quiz' => $quiz,
            'isCorrectAnswer' => $isCorrectAnswer,
        ]);
    }

    // 解答判定処理
    private function isCorrectAnswer($selectOptionId, $quizOptions)
    {
        // 正解の選択肢を探す
        $correctOption = null;
        foreach($quizOptions as $quizOption) {
            // オプションの中で正解のものだけ取得
            if($quizOption['is_correct']) {
                $correctOption = $quizOption;
            }
        }
        return $correctOption['id'] === (int)$selectOptionId;
        // 選択肢が正解か判定

    }
}
