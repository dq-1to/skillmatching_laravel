<?php

// app/Http/Controllers/Admin/UserListController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserListController extends Controller
{
    public function index(Request $req)
    {
        $q = User::withCount('postReports');

        if ($kw = $req->input('q')) {
            $q->where(function($w) use($kw){
                $w->where('name','like',"%{$kw}%")
                  ->orWhere('email','like',"%{$kw}%");
            });
        }

        if ($req->input('sort') === 'reports') {
            $q->orderBy('post_reports_count','desc');
        } else {
            $q->orderBy('created_at','desc');
        }

        $users = $q->paginate(30)->appends($req->query());
        return view('admin.users.index', compact('users'));
    }

    public function toggle(User $user)
    {
        $user->update(['del_flag' => $user->del_flag ? 0 : 1]);
        return back()->with('success','ユーザーの状態を切り替えました');
    }
}
