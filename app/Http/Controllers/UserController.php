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

    // 文字列で受け取る
    public function quizzes($level)
    {
        $levelModel = Level::with('quizzes')->where('key', $level)->firstOrFail();


        return view('user.quizzes', [
            'level' => $level,
            'quizzes' => $levelModel->quizzes
        ]);
    }
}
