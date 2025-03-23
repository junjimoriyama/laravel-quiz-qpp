<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuizRequest;
use App\Models\Level;
use App\Models\Option;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    const MAX_QUIZ_COUNT = 10;
    // クイズ新規画面表示
    public function create($level)
    {
        $levelModel = Level::where('key', $level)->firstOrFail();
        return view('admin.quizzes.create', compact('levelModel'));
    }

    // クイズ新規登録
    public function store(StoreQuizRequest $request, $level)
    {
        // 文字列 $level からモデル取得
        $levelModel = Level::where('key', $level)->firstOrFail();

        // 該当するクイズを全て取得
        $quizzes = Quiz::where('level_id', $levelModel->id)->get();

        // もしクイズの数が10より少なければ
        if (count($quizzes) <= self::MAX_QUIZ_COUNT) {
            $quiz = new Quiz();
            // レベルとの紐付け
            $quiz->level_id = $levelModel->id;
            $quiz->question = $request->question;
            $quiz->solution = $request->solution;
            $quiz->save();

            for ($i = 1; $i <= 4; $i++) {
                $option = new Option();
                $option->quiz_id = $quiz->id;
                $option->content = $request->content[$i - 1];
                $option->is_correct = $request->correct_answer == $i ? 1 : 0;
                $option->save();
            }

            // リダイレクト時もlevelはkeyを渡す
            return to_route('admin.quizzes.show', [
                'level' => $levelModel->key,
            ]);
        } else {
            return back()->with('error', '登録は最大' . self::MAX_QUIZ_COUNT . '問までです。');
        }
    }


    // クイズ表示
    public function show($level)
    {
        // 該当のレベル取得
        $level = Level::where('key', $level)->firstOrFail();
        // 該当の全てのクイズ取得
        $quizzes = Quiz::where('level_id', $level->id)->get();
        // 登録クイズ数の制限
        $canResister = count($quizzes) < self::MAX_QUIZ_COUNT;

        return view('admin.quizzes.show', compact('level', 'quizzes', 'canResister'));
    }

    // クイズ編集
    public function edit($level, Quiz $quiz)
    {
        // dd($level);
        // 該当レベル取得
        $level = Level::where('key', $level)->firstOrFail();
        // 該当レベルの全てのクイズ
        $options = Option::where('quiz_id', $quiz->id)->get()->toArray();

        return view('admin.quizzes.edit', compact('level', 'quiz', 'options'));
    }

    // クイズ更新画面表示
    public function update(Request $request, $level, Quiz $quiz)
    {
        // 該当レベル取得
        $level = Level::where('key', $level)->firstOrFail();

        $quizzes = Quiz::where('level_id', $level->id)->get();

        $canResister = count($quizzes) < self::MAX_QUIZ_COUNT;

        // クイズモデル
        $quiz->level_id = $level->id;
        $quiz->question = $request->question;
        $quiz->solution = $request->solution;

        // 選択肢の更新
        foreach ($quiz->options as $index => $option) {
            $option->content = $request->content[$index];
            $option->is_correct = ($request->correct_answer == $index + 1) ? 1 : 0;
            $option->save();
        }
        return to_route('admin.quizzes.show', ['level' => $level->key]);
    }

    public function destroy(Level $level, Quiz $quiz)
    {
        $quiz->delete();
        return to_route('admin.quizzes.show', ['level' => $level->key]);
    }
}
