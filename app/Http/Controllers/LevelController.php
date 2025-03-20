<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function showForm($level)
    {
        // levelテーブルのデータを使用
        $level = Level::where('key', $level)->firstOrFail();
        // 難易度を
        return view('admin.levels.form', compact('level'));
    }
}
