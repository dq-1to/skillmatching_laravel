<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $userCount = User::where('del_flag', 0)->count();
        $postCount = Post::where('del_flag', 0)->count();

        
        return view('admin.dashboard', compact('userCount', 'postCount'));
    }

    public function userlist()
    {
        $users = User::where('del_flag', 0)->paginate(20);
        
        return view('admin.userlist', compact('users'));
    }

    public function postslist()
    {
        $posts = Post::where('del_flag', 0)->with('user')->paginate(20);
        
        return view('admin.postslist', compact('posts'));
    }
}
