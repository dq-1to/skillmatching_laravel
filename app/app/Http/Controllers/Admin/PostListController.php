<?php

// app/Http/Controllers/Admin/PostListController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class PostListController extends Controller
{
    public function index(Request $req)
    {
        $q = Post::with('user')->withCount('reports');

        if ($kw = $req->input('q')) {
            $q->where(function($w) use($kw){
                $w->where('title','like',"%{$kw}%")
                  ->orWhere('content','like',"%{$kw}%");
            });
        }

        // sort: reports desc
        if ($req->input('sort') === 'reports') {
            $q->orderBy('reports_count','desc');
        } else {
            $q->orderBy('created_at','desc');
        }

        $posts = $q->paginate(30)->appends($req->query());
        return view('admin.posts.index', compact('posts'));
    }

    // 公開/停止 切替（del_flag）
    public function toggle(Post $post)
    {
        $post->update(['del_flag' => $post->del_flag ? 0 : 1]);
        return back()->with('success','投稿の状態を切り替えました');
    }
}

