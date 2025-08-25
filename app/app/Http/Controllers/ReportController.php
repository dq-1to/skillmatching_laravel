<?php

namespace App\Http\Controllers;

use App\Post;
use App\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function create(Request $req)
    {
        $post = Post::where('del_flag',0)->findOrFail($req->query('post'));
        return view('reports.create', compact('post'));
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'post_id' => 'required|exists:posts,id',
            'reason'  => 'required|string|max:2000'
        ]);

        $data['reporter_id'] = $req->user()->id;
        $data['status'] = 0;
        $data['del_flag'] = 0;

        $report = Report::create($data);
        return redirect()->route('reports.show', $report)->with('success', '通報を送信しました。');
    }

    public function show(Report $report)
    {
        // 自分の通報以外は見せない
        if ($report->reporter_id !== auth()->id()) abort(403);
        if ($report->del_flag) abort(404);

        return view('reports.show', compact('report'));
    }
}
