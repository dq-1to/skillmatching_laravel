<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query()
            ->titleLike($request->input('title'))
            ->freeword($request->input('q'))
            ->priceMin($request->input('min'))
            ->priceMax($request->input('max'))
            ->where('del_flag', 0) // 論理削除されていないものだけ
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->appends($request->query());
        
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function show(Post $post)
    {
        // 論理削除済みは表示しない
        if ($post->del_flag) {
            abort(404);
        }
        return view('posts.show', compact('post'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['user_id'] = auth()->id();
        $data['del_flag'] = 0;

        // 画像アップロード処理
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        Post::create($data);

        return redirect()->route('posts.index')->with('success', '投稿が作成されました');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);

        return redirect()->route('posts.index')->with('success', '投稿が更新されました');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        // 論理削除フラグを立てる
        $post->update(['del_flag' => 1]);

        return redirect()->route('posts.index')->with('success', '投稿が削除されました');
    }

    /** 簡易バリデーション */
    private function validated(Request $request)
    {
        return $request->validate([
            'title'   => 'required|string|max:50',
            'content' => 'required|string|max:200', // ← bodyから修正
            'price'   => 'required|integer|min:0',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // 追加
        ]);
    }
}
