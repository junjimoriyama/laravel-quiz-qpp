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
        $optionId = $request->optionId;

        $this->isCorrectAnswer();

        $levelModel = Level::with('quizzes.options')->where('key', $level)->firstOrFail();
        $quizzes = $levelModel->quizzes;

        $quiz = $quizzes->firstWhere('id', $quizId);

        dd( $quiz->options);

        // 該当のクイズ
        // $quiz = array_filter($quizzes, fn($quiz) => $quiz['id'] === (int)$request->quizId);




        return view('user.answer', [
            // 'quiz' => $quiz
        ]);
    }

    // プレイヤーの解答が正解かどうか
    private function isCorrectAnswer()
    {

    }
}

// $quizzes = $levelModel->quizzes;


// $quiz = $quizzes->firstWhere('id', $quizId );

// dd($quiz);

// $quiz =  array_filter($quizzes, fn($quiz) => $quiz['id'] === (int)$request->quizId);
