@extends('layouts.app')
@section('content')
<div class="container">
  <h1>管理ダッシュボード</h1>

  {{-- KPI 行 --}}
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card"><div class="card-body">
        <div class="text-muted">違反投稿</div>
        <div class="h4 mb-0">{{ $kpiViolationPosts }} / {{ $totalPosts }}</div>
      </div></div>
    </div>
    <div class="col-md-4">
      <div class="card"><div class="card-body">
        <div class="text-muted">違反ユーザー</div>
        <div class="h4 mb-0">{{ $kpiViolationUsers }} / {{ $totalUsers }}</div>
      </div></div>
    </div>
    <div class="col-md-4">
      <div class="card"><div class="card-body">
        <div class="text-muted">全体統計</div>
        <div class="h6 mb-0">投稿: {{ $totalPosts }} / ユーザー: {{ $totalUsers }} / 報告: {{ $totalReports }}</div>
      </div></div>
    </div>
  </div>

  <div class="row">
    {{-- ②投稿リスト（上位20） --}}
    <div class="col-md-6">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
          <span>違反報告が多い投稿（上位20）</span>
                     <a href="{{ route('admin.postslist') }}" class="btn btn-sm btn-outline-secondary">もっと見る</a>
        </div>
        <ul class="list-group list-group-flush">
          @foreach($hotPosts as $p)
            <li class="list-group-item d-flex justify-content-between">
              <span class="text-truncate" style="max-width:70%">{{ $p->title }}</span>
              <span class="badge badge-danger">{{ $p->reports_count }}</span>
            </li>
          @endforeach
        </ul>
      </div>
    </div>

    {{-- ③ユーザーリスト（上位10） --}}
    <div class="col-md-6">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
          <span>違反の多いユーザー（上位10）</span>
                     <a href="{{ route('admin.userlist') }}" class="btn btn-sm btn-outline-secondary">もっと見る</a>
        </div>
        <ul class="list-group list-group-flush">
          @foreach($hotUsers as $u)
            <li class="list-group-item d-flex justify-content-between">
              <span class="text-truncate" style="max-width:70%">{{ $u->name }}（{{ $u->email }}）</span>
              <span class="badge badge-danger">{{ $u->post_reports_count }}</span>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
  </div>
  
  {{-- 管理機能へのリンク --}}
  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">管理機能</h5>
        </div>
        <div class="card-body">
          <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.reports.index') }}" class="btn btn-primary">通報一覧</a>
            <a href="{{ route('admin.userlist') }}" class="btn btn-secondary">ユーザー管理</a>
            <a href="{{ route('admin.postslist') }}" class="btn btn-info">投稿管理</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
