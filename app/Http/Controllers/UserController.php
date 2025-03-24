<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Quiz;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function top()
    {
        $levels = Level::all();

        return view('user.top', compact('levels'));
    }

    public function levels($level)
    {
        // dd($level);
        $levelModel = Level::withCount('quizzes')->where('key', $level)->firstOrFail();

        return view('user.levels', [
            'levelModel' => $levelModel,
            'level' => $level,
            'quizzesCount' => $levelModel->quizzes_count
        ]);
    }

    // 各クイズ表示
    public function quizzes($level)
    {
        $levelModel = Level::with('quizzes.options')->where('key', $level)->firstOrFail();

        $quizzes = $levelModel->quizzes->toArray();

        shuffle($quizzes);

        $quiz = $quizzes[0];

        // dd($level);

        return view('user.quizzes', [
            'level' => $level,
            // 'quizzes' => $quizzes,
            'quiz' => $quiz
        ]);
    }

    // 正解を送る
    public function answer(Request $request, $level)
    {
        // クイズID
        $quizId = $request->quizId;
        // オプションID
        $selectOption = $request->optionId;

        $levelModel = Level::with('quizzes.options')->where('key', $level)->firstOrFail();
        // 全てのクイズ
        $quizzes = $levelModel->quizzes;
        // 該当のクイズ
        $quiz = $quizzes->firstWhere('id', $quizId);

        $quizOptions = $quiz->options->toArray();

        $result = $this->isCorrectAnswer($selectOption, $quizOptions);

        return view('user.answer', [
            'level' => $level,
            'quiz' => $quiz,
            'result' => $result,
        ]);
    }

    // プレイヤーの解答が正解かどうか
    private function isCorrectAnswer($selectOption, $quizOptions) {
        // $selectOptionが$quizOptionsの正解のIdと一致するかどうか
        $collectOption = null;
        foreach($quizOptions as $option) {
            if($option['is_correct']) {
                $collectOption = $option;
                break;
            }
        }


        if($collectOption['id'] !== (int)$selectOption) {
            return false;
        }
        return true;
    }
}

// $quizzes = $levelModel->quizzes;


// $quiz = $quizzes->firstWhere('id', $quizId );

// dd($quiz);

// $quiz =  array_filter($quizzes, fn($quiz) => $quiz['id'] === (int)$request->quizId);
