<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * ログイン後のリダイレクトを役割で分岐
     */
    protected function authenticated(Request $request, User $user)
    {
        if ((int) $user->role === 1) {
            return redirect()->route('admin.dashboard'); // 管理者は管理者ダッシュボードに
        }
        return redirect('/'); // 一般ユーザーはメインページ（投稿一覧）に
    }
}
