<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;
use App\User;
use App\Report;

class DashboardController extends Controller
{
    public function index()
    {
        // KPIデータを取得
        $totalPosts = Post::where('del_flag', 0)->count();
        $totalUsers = User::where('del_flag', 0)->count();
        $totalReports = Report::where('del_flag', 0)->count();
        
        // 違反投稿数（通報された投稿）
        $kpiViolationPosts = Post::whereHas('reports', function($query) {
            $query->where('del_flag', 0);
        })->count();
        
        // 違反ユーザー数（通報された投稿を持つユーザー）
        $kpiViolationUsers = User::whereHas('posts.reports', function($query) {
            $query->where('del_flag', 0);
        })->count();
        
        // 通報が多い投稿（上位20）
        $hotPosts = Post::withCount(['reports' => function($query) {
            $query->where('del_flag', 0);
        }])
        ->where('del_flag', 0)
        ->orderBy('reports_count', 'desc')
        ->limit(20)
        ->get();
        
        // 通報が多いユーザー（上位10）
        $hotUsers = User::withCount(['posts as post_reports_count' => function($query) {
            $query->whereHas('reports', function($q) {
                $q->where('del_flag', 0);
            });
        }])
        ->where('del_flag', 0)
        ->orderBy('post_reports_count', 'desc')
        ->limit(10)
        ->get();
        
        return view('admin.dashboard', compact(
            'kpiViolationPosts',
            'totalPosts',
            'kpiViolationUsers',
            'totalUsers',
            'totalReports',
            'hotPosts',
            'hotUsers'
        ));
    }
}
