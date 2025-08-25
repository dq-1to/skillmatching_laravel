<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use App\User;
use Illuminate\Support\Facades\Crypt;

class CustomPasswordResetController extends Controller
{
    /**
     * パスワードリセットページを表示
     */
    public function showResetForm()
    {
        return view('auth.passwords.custom-email');
    }

    /**
     * メールアドレスを確認してリセットリンクを生成
     */
    public function generateResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $email = $request->email;
        
        // ユーザーを取得
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => '指定されたメールアドレスが見つかりません。']);
        }

        // Laravelの標準的なパスワードリセット機能と同じ方法でトークンを生成
        $token = Str::random(60);
        
        // パスワードリセットテーブルに保存（既存のレコードがあれば更新）
        \DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            [
                'email' => $email,
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        // セッションにメールアドレスと生のトークンを保存
        session(['reset_email' => $email, 'reset_token' => $token]);

        return back()->with('reset_link_generated', true);
    }

    /**
     * パスワードリセットページにリダイレクト
     */
    public function redirectToReset()
    {
        $email = session('reset_email');
        $rawToken = session('reset_token');

        if (!$email || !$rawToken) {
            return redirect()->route('password.request')->withErrors(['email' => 'リセットリンクが無効です。']);
        }

        // データベースからハッシュ化されたトークンを取得
        $resetRecord = \DB::table('password_resets')
            ->where('email', $email)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$resetRecord || !Hash::check($rawToken, $resetRecord->token)) {
            return redirect()->route('password.request')->withErrors(['email' => 'リセットリンクが無効です。']);
        }

        // 生のトークンを使用してリダイレクト（Laravelの標準機能がハッシュを検証）
        return redirect()->route('password.reset', ['token' => $rawToken, 'email' => $email]);
    }
}
