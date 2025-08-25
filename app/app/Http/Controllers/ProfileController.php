<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        // バリデーション（メールは自分を除外してユニーク）
        $data = $request->validate([
            'name'     => 'required|string|max:50',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'icon'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            // パスワードは任意。入っていれば確認と最小長チェック
            'password' => 'nullable|confirmed|min:8',
        ]);

        // アイコン差し替え
        if ($request->hasFile('icon')) {
            // 以前のファイルを消したければここで Storage::disk('public')->delete($user->icon);
            $data['icon'] = $request->file('icon')->store('users', 'public');
        }

        // パスワードは入力があった時だけ更新
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('mypage.show')->with('success', 'プロフィールを更新しました。');
    }

    public function destroy(Request $request)
    {
        $user = auth()->user();

        // 退会確認のための簡易チェック（必要ならパスワード確認を追加）
        $request->validate([
            'confirm' => 'required|in:DELETE',
        ]);

        // 論理削除フラグ（users.del_flag = 1）
        $user->update(['del_flag' => 1]);

        // ログアウトしてセッション破棄
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', '退会が完了しました。');
    }
}
