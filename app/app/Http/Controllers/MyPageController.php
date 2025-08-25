<?php

namespace App\Http\Controllers;

use App\Post;
use App\JobRequest;
use Illuminate\Http\Request;

class MyPageController extends Controller
{
    public function show(Request $request)
    {
        $uid = auth()->id();

        // ①自分の投稿 最新10件
        $myPosts = Post::where('user_id', $uid)
            ->where('del_flag', 0)
            ->latest()->take(10)->get(['id','title','price','created_at']);

        // ②自分が送った依頼 最新10件
        $sentRequests = JobRequest::with(['post'])
            ->where('user_id', $uid)->where('del_flag', 0)
            ->latest()->take(10)->get();

        // ③自分が受けた依頼（自分の投稿宛） 最新10件
        $receivedRequests = JobRequest::with(['user','post'])
            ->whereHas('post', function($q) use ($uid){
                $q->where('user_id', $uid);
            })
            ->where('del_flag', 0)
            ->latest()->take(10)->get();

        // ④ブックマーク（未実装なら空でOK／実装済みなら書き換え）
        // 例：User hasManyThrough or belongsToMany Posts via bookmarks
        $bookmarkedPosts = collect(); // とりあえず空
        // 実装済みなら例：
        // $bookmarkedPosts = auth()->user()->bookmarks()
        //     ->with('post')... or posts()->latest()->take(10)->get();

        return view('mypage.show', compact(
            'myPosts','sentRequests','receivedRequests','bookmarkedPosts'
        ));
    }
}
