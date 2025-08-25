<?php

namespace App\Http\Controllers;

use App\JobRequest;
use App\Post;
use Illuminate\Http\Request as HttpRequest;

class RequestController extends Controller
{
    public function index(HttpRequest $req)
    {
        $mode = $req->query('box', 'sent'); // 'sent' or 'received'
        $base = \App\JobRequest::with(['post', 'user'])->alive()->orderBy('created_at', 'desc');

        if ($mode === 'received') {
            $requests = $base->byRecipient(auth()->id())->paginate(12)->appends($req->query());
        } else {
            $requests = $base->byRequester(auth()->id())->paginate(12)->appends($req->query());
            $mode = 'sent';
        }

        return view('requests.index', compact('requests', 'mode'));
    }

    public function create(HttpRequest $req)
    {
        // /requests/create?post=ID で対象投稿を指定できるように
        $post = Post::find($req->query('post'));
        return view('requests.create', compact('post'));
    }

    public function store(HttpRequest $req)
    {
        $data = $this->validated($req);
        $data['user_id'] = auth()->id();
        $data['del_flag'] = 0;

        JobRequest::create($data);
        return redirect()->route('requests.index')->with('success', '依頼を送信しました');
    }

    public function show(JobRequest $reqItem)
    {
        if ($reqItem->del_flag)
            abort(404);

        // ビュー側で request() ヘルパと名前が被らないよう $req で渡す
        return view('requests.show', ['req' => $reqItem]);
    }

    public function edit(JobRequest $reqItem)
    {
        if ((int) $reqItem->user_id !== (int) auth()->id()) {
            abort(403);
        }
        return view('requests.edit', ['req' => $reqItem]);
    }

    public function update(HttpRequest $req, JobRequest $reqItem)
    {
        // 受信者（投稿者）によるステータス更新
        if ($req->has('status')) {
            if ((int) $reqItem->post->user_id !== (int) auth()->id())
                abort(403);

            $data = $req->validate([
                'status' => 'required|in:0,1,2',
            ]);
            $reqItem->update($data);

            return redirect()->route('requests.show', $reqItem)->with('success', 'ステータスを更新しました');
        }

        // 依頼者による内容編集
        if ((int) $reqItem->user_id !== (int) auth()->id())
            abort(403);

        $data = $req->validate([
            'content' => 'required|string|max:2000',
            'tel' => 'nullable|regex:/^[0-9]{10,15}$/',
            'email' => 'required|email',
            'due_date' => 'nullable|date|after:today',
            // post_id, status, del_flag は編集させない
        ]);

        $reqItem->update($data);

        return redirect()->route('requests.show', $reqItem)->with('success', '依頼内容を更新しました');
    }

    public function destroy(JobRequest $reqItem)
    {
        // 依頼者のみ削除可（論理削除）
        if ((int) $reqItem->user_id !== (int) auth()->id()) {
            abort(403);
        }

        // 進行中・完了は削除不可にしたい場合は以下を有効化
        // if ((int)$reqItem->status !== 0) {
        //     return back()->with('error', '進行中/完了の依頼は削除できません');
        // }

        $reqItem->update(['del_flag' => 1]);

        return redirect()->route('requests.index')->with('success', '依頼を削除しました');
    }

    private function validated(HttpRequest $request)
    {
        return $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:2000',
            'tel' => 'nullable|regex:/^[0-9]{10,15}$/',
            'email' => 'required|email',
            'due_date' => 'nullable|date|after:today',
            'status' => 'required|in:0,1,2',
        ]);
    }
}
