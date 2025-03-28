<?php
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

use App\Http\Controllers\UserController;
// use App\Http\Controllers\LevelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;


// ユーザートップ画面
Route::get('/', [UserController::class, 'top'])->name('top');

// ユーザー
Route::prefix('user')->name('user.')->group(function () {
    // レコード画面表示
    Route::get('records', [UserController::class, 'records'])->name('records');
    // 各レベルのスタート画面
    Route::get('levels/{level}', [UserController::class, 'levels'])->name('levels');
    // レベル
    Route::prefix('levels/{level}')->name('levels.')->group(function () {
        // クイズ出題画面に遷移
        Route::get('quizzes', [UserController::class, 'quizzes'])->name('quizzes');
        // クイズ出題画面に遷移
        Route::post('quizzes/answer', [UserController::class, 'answer'])->name('quizzes.answer');
        // クイズ結果画面に遷移
        Route::get('quizzes/result', [UserController::class, 'result'])->name('quizzes.result');
    });
});

// 認証
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ログイン
require __DIR__ . '/auth.php';

// ログイン中のみ表示可能
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // 管理者トップページ表示
    Route::get('/top', function () {
        return view('admin.top');
    })->name('top');

    // レベル表示
    // Route::get('/levels/{level}', [LevelController::class, 'showForm'])->name('levels.form');

    // クイズ登録系
    Route::prefix('levels/{level}/quizzes')->name('quizzes.')->group(function () {
        // クイズ新規登録画面
        Route::get('create', [QuizController::class, 'create'])->name('create');
        // クイズ保存
        Route::post('store', [QuizController::class, 'store'])->name('store');
        // クイズ表示
        Route::get('show', [QuizController::class, 'show'])->name('show');
        // クイズ編集画面表示
        Route::get('{quiz}/edit', [QuizController::class, 'edit'])->name('edit');
        // クイズ更新
        Route::put('{quiz}/update', [QuizController::class, 'update'])->name('update');
        // クイズ削除
        Route::delete('{quiz}/destroy', [QuizController::class, 'destroy'])->name('destroy');
    });
});

// Route::prefix('levels')->('levels.')->group(funcrion () {

// })

// ① route('admin.levels.form', 'basic') がクリック or 実行される
// ↓
// ② URL /admin/levels/basic にアクセスされる
// ↓
// ③ Laravelのルート /levels/{level} が反応
// ↓
// ④ LevelController@showForm() が呼ばれる
// ↓
// ⑤ $level = Level::where('key', 'basic')->firstOrFail(); → データ取得
// ↓
// ⑥ view('admin.levels.form') で HTMLを返す
// ↓
// ⑦ ブラウザがそのHTML（画面）を表示
