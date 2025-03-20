<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function showForm($level)
    {
        $level = Level::where('key', $level)->firstOrFail();
        return view('admin.levels.form', compact('level'));
    }
}
