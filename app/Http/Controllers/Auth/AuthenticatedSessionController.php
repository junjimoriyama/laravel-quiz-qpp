<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * ログイン処理
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // バリデーション
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string']
        ]);

        // ログイン試行(次回来たときにログインし直さなくていい)
        if(!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => '認証に失敗しました'
            ]);
        }

        // セッションを再生成
        $request->session()->regenerate();

        // ログインユーザーの情報取得
        $user = Auth::user();

        // dd($request->has('admin_login'), $user->is_admin);

        // 管理者チェックが付いていて、管理者でなかった場合はログアウト
        if ($request->has('admin_login') && !$user->is_admin) {
            Auth::logout();
            return to_route('login')->withErrors([
                'email' => '管理者ではありません。'
            ]);
        }

        // 管理者チェックがあり、かつ管理者なら admin.top へリダイレクト
        if ($request->has('admin_login') && $user->is_admin) {
            return to_route('admin.top');
        }

        // 一般ユーザーは通常のHOMEへ
        return redirect()->intended('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login');
    }
}


   /**
     * ログイン処理
     */
    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     $request->authenticate();

    //     $request->session()->regenerate();

    //     return redirect()->intended(route('admin.top', absolute: false));
    // }

// タイミング	　　セッション状態
// 初回アクセス	✅ 未認証のセッション（匿名セッション）作成
// ログインの試み	✅ 上記セッションを使って認証試行
// ログイン成功	🔁 セッションIDを再生成（安全対策）
// ログイン中	✅ 新しいセッションIDで認証済み状態
// ログアウト	🔁 セッションを破棄 or 再生成
// 次回アクセス	✅ ログアウト後に生成された未認証セッション
// 再ログインの試み	✅ 同上セッションを使って認証試行
// 再ログイン成功	🔁 再びセッションIDを再生成
