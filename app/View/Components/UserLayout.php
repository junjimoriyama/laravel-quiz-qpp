<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class UserLayout extends Component
{
    /**
     * 管理者画面共通レイアウト
     */
    public function render(): View
    {
        return view('layouts.user');
    }
}
