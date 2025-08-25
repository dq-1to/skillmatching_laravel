<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // ロールに基づく分岐
        if (Auth::user()->role === 1) {
            return redirect()->route('admin.dashboard');
        }
        
        // 一般ユーザーはメインページ（投稿一覧）にリダイレクト
        return redirect('/');
    }
}
