<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;
use App\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $req)
    {
        $q = Report::with(['post','reporter'])->alive()->orderBy('created_at','desc');
        if ($req->filled('status')) $q->where('status', (int)$req->status); // 0/1/2
        $reports = $q->paginate(20)->appends($req->query());
        return view('admin.reports.index', compact('reports'));
    }

    public function show(Report $report)
    {
        if ($report->del_flag) abort(404);
        $report->load(['post','reporter']);
        return view('admin.reports.show', compact('report'));
    }

    public function update(Request $req, Report $report)
    {
        $data = $req->validate(['status' => 'required|in:0,1']); // ← 0/1 に修正
        $report->update($data);
        return back()->with('success', 'ステータスを更新しました。');
    }

    public function destroy(Report $report)
    {
        $report->update(['del_flag' => 1]);
        return redirect()->route('admin.reports.index')->with('success', '通報を削除しました。');
    }
}