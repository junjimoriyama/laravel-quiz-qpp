<?php
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

use App\Http\Controllers\LevelController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// 初めに開かれる画面
Route::get('/', function () {
    return view('user/top');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ログイン
require __DIR__.'/auth.php';

// ログイン中のみ表示可能
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // 管理者トップページ表示
    Route::get('/top', function() {
        return view('admin.top');
    })->name('top');
    // 問題文表示
    Route::get('/levels/{level}', [LevelController::class, 'showForm'])->name('levels.form');
});

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

