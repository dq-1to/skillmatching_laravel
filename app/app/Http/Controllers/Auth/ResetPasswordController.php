<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse(Request $request, $response)
    {
        // パスワードリセットが成功した場合、ユーザーを自動ログイン
        $user = User::where('email', $request->email)->first();
        if ($user) {
            Auth::login($user);
            
            // ユーザーの役割に応じてリダイレクト先を決定
            if ($user->role === 1) {
                // 管理者の場合
                return redirect()->route('admin.dashboard')->with('status', trans($response));
            } else {
                // 一般ユーザーの場合
                return redirect()->route('home')->with('status', trans($response));
            }
        }

        // ユーザーが見つからない場合のフォールバック
        return redirect()->route('login')->with('status', trans($response));
    }
}
