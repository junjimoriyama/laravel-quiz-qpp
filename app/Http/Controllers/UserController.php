<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswerQuizRequest;
use App\Models\Level;
use App\Models\Quiz;
use App\Models\Record;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // トップページ表示
    public function top()
    {
        // ログインしていなければ
        if(!Auth::check()){
            return to_route('login');
        }
        // ログインしていれば
        $levels = Level::all();
        return view('user.top', compact('levels'));

    }

    // レベル選択後のスタート画面表示（セッション初期化）
    public function levels($level)
    {
        // 過去の結果をクリア
        session()->forget('quizResultsArray');

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
        $quizResultsArray = session('quizResultsArray');

        // レベルのクイズと選択肢を取得
        $levelModel = Level::with('quizzes.options')->where('key', $level)->firstOrFail();
        $quizzes = $levelModel->quizzes;

        // 初回のみセッションにクイズ一覧をセット（シャッフル）
        if (!$quizResultsArray) {
            $quizIds = $quizzes->pluck('id')->toArray();
            shuffle($quizIds);

            $quizResultsArray = array_map(fn($quizId) => [
                'quizId' => $quizId,
                'result' => null
            ], $quizIds);

            session(['quizResultsArray' => $quizResultsArray]);
        }

        // 未回答のクイズを取得
        $noAnswerQuiz = collect($quizResultsArray)->filter(fn($item) => $item['result'] === null)->first();

        // 現在のクイズ番号を計算
        if ($noAnswerQuiz) {
            $currentQuizIndex = 0;
            foreach ($quizResultsArray as $index => $result) {
                if ($result['quizId'] === $noAnswerQuiz['quizId']) {
                    $currentQuizIndex = $index + 1; // 配列は0スタート
                    break;
                }
            }
            // クイズの詳細情報取得
            $quiz = $quizzes->firstWhere('id', $noAnswerQuiz['quizId']);
        } else {
            // 全問回答済みなら結果画面へ
            return to_route('user.levels.quizzes.result', [
                'level' => $level,
            ]);
        }
        // 一度クイズに答えたクイズに再度答えようするときのメッセージ
        $message = session('message');
        // クイズ画面を表示
        return view('user.quizzes', [
            'level' => $level,
            'quiz' => $quiz,
            'currentQuizIndex' => $currentQuizIndex,
            'message' => $message,
        ]);
    }

    // 解答送信処理
    public function answer(AnswerQuizRequest $request, $level)
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
        $quizResultsArray = session('quizResultsArray', []);

        // 該当クイズの結果を更新
        foreach ($quizResultsArray as $index => $result) {
            if ($result['quizId'] === (int)$quizId) {
                if ($result['result'] !== null) {
                    // すでに回答済み → 次のクイズに進む（戻ることはない）
                    return to_route('user.levels.quizzes', ['level' => $level])
                        ->with('message', '次の問題です。');
                } else {
                    // 未回答 → 回答を記録
                    $quizResultsArray[$index]['result'] = $isCorrectAnswer;
                    break;
                }
            }
        }
        // 更新した結果をセッション保存
        session(['quizResultsArray' => $quizResultsArray]);

        $remainingQuizCount = collect($quizResultsArray)->filter(fn($item) => $item['result'] === null)->count();

        // dump($remainingQuizCount);

        // 解答結果表示
        return view('user.answer', [
            'remainingQuizCount' => $remainingQuizCount,
            'quizResultsArray' => $quizResultsArray,
            'level' => $level,
            'quiz' => $quiz,
            'isCorrectAnswer' => $isCorrectAnswer,
        ]);
    }

    // 結果画面表示
    public function result($level)
    {
        // レベルのid
        $levelId = Level::where('key', $level)->firstOrFail()->id;
        // dd($levelId);
        // 結果の情報
        $quizResultsArray = session('quizResultsArray');
        // クイズ数
        $quizzesCount = count($quizResultsArray);
        // 答えてないクイズをカウント
        $correctAnswerCount = collect($quizResultsArray)->filter(fn($item) => $item['result'] === true)->count();
        $score = $correctAnswerCount * 10;
        // 正解率
        $correctPercentage = (int)round((($correctAnswerCount / $quizzesCount) * 100));

        // レコード数を取得
        $user = Auth::user();
        $records = $user->records;
        // 現在のレベルのカウント数
        $currentLevelCount =  $records->where('level_id', $levelId)->count();

        if ($currentLevelCount < 100) {
            Record::create([
                'user_id' => Auth::id(),
                'level_id' => $levelId,
                'score' => $score,
                'correct_percentage' => $correctPercentage,
            ]);
        }

        // 結果画面に遷移
        return view('user/result', [
            'quizResultsArray' => $quizResultsArray,
            'quizzesCount' => $quizzesCount,
            'correctAnswerCount' =>  $correctAnswerCount,
            'correctPercentage' =>  $correctPercentage,
        ]);
    }

    // 今までの結果を表示
    public function records()
    {
        // ユーザー情報
        $user = Auth::user();
        $records = $user->records;
        // 各レベルの連想配列
        $levelsArray = [
            1 => '初級',
            2 => '中級',
            3 => '上級',
        ];
        // 各レベルのレコード数のうち、最大の件数
        $recordsMaxCount = $records->groupBy('level_id')->map->count()->max();

        return view('user.records', compact('user', 'records', 'levelsArray', 'recordsMaxCount'));
    }


    // 解答判定処理
    private function isCorrectAnswer($selectOptionId, $quizOptions)
    {
        // 正解の選択肢を探す
        $correctOption = null;
        foreach ($quizOptions as $quizOption) {
            // オプションの中で正解のものだけ取得
            if ($quizOption['is_correct']) {
                $correctOption = $quizOption;
            }
        }
        return $correctOption['id'] === (int)$selectOptionId;
        // 選択肢が正解か判定

    }
}
