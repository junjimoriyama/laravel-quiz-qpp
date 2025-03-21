<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Option;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    const MAX_QUIZ_COUNT = 4;
    // クイズ新規画面表示
    public function create($level)
    {
        $level = Level::where('key', $level)->firstOrFail();
        return view('admin.quizzes.create', compact('level'));
    }

    // クイズ新規登録
    public function store(Request $request, $level)
    {
        // まず該当のレベルを取得
        $level = Level::where('key', $level)->firstOrFail();
        // 該当するクイズを全て取得
        $quizzes = Quiz::where('level_id', $level->id)->get();
        // もしクイズの数が10より少なければ
        if (count($quizzes) <= self::MAX_QUIZ_COUNT) {
            // 該当のレベルを取得
            $level = Level::where('key', $level)->firstOrFail();
            $quiz = new Quiz();
            // レベルとの紐付け
            $quiz->level_id = $level->id;
            $quiz->question = $request->question;
            $quiz->solution = $request->solution;
            $quiz->save();

            for ($i = 1; $i <= 4; $i++) {
                $option = new Option();
                // クイズと紐付け
                $option->quiz_id = $quiz->id;
                $option->content = $request->content[$i - 1];
                // 選択された正解番号と一致した場合だけ正解(1)にする
                $option->is_correct = $request->correct_answer == $i ? 1 : 0;
                $option->save();
            }
        } else {
            return back()->with('error', '登録は最大' . self::MAX_QUIZ_COUNT . '問までです。');
        }
        // 該当レベルのクイズ一覧に戻る
        return to_route('admin.quizzes.show', [
            'level' => $level->key,
        ]);
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
        $quiz->save();

        // 選択肢の更新
        foreach ($quiz->options as $index => $option) {
            $option->content = $request->content[$index];
            $option->is_correct = ($request->correct_answer == $index + 1) ? 1 : 0;
            $option->save();
        }
        return view('admin.quizzes.show', compact('level', 'quizzes', 'canResister'));
    }
}
