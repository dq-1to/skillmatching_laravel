@extends('layouts.app')
@section('content')
<div class="container py-4">
  <h1 class="h3 fw-bold mb-4">管理ダッシュボード</h1>

  {{-- 管理機能へのリンク --}}
  <div class="row mb-4">
    <div class="col-12">
      <div class="card border">
        <div class="card-header bg-light">
          <h5 class="mb-0 fw-bold">管理機能</h5>
        </div>
        <div class="card-body py-4">
          <div class="d-flex gap-3 flex-wrap">
            <a href="{{ route('admin.reports.index') }}" class="btn btn-primary px-4 py-2">
              通報一覧
            </a>
            <a href="{{ route('admin.userlist') }}" class="btn btn-secondary px-4 py-2">
              ユーザー管理
            </a>
            <a href="{{ route('admin.postslist') }}" class="btn btn-info px-4 py-2">
              投稿管理
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- KPI 行 --}}
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card border h-100">
        <div class="card-body text-center py-4">
          <div class="text-muted small mb-2">違反投稿</div>
          <div class="h3 fw-bold mb-0 text-danger">{{ $kpiViolationPosts }} / {{ $totalPosts }}</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border h-100">
        <div class="card-body text-center py-4">
          <div class="text-muted small mb-2">違反ユーザー</div>
          <div class="h3 fw-bold mb-0 text-warning">{{ $kpiViolationUsers }} / {{ $totalUsers }}</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border h-100">
        <div class="card-body text-center py-4">
          <div class="text-muted small mb-2">全体統計</div>
          <div class="h6 mb-0">
            <div class="mb-1">投稿: {{ $totalPosts }}</div>
            <div class="mb-1">ユーザー: {{ $totalUsers }}</div>
            <div>報告: {{ $totalReports }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    {{-- 違反報告が多い投稿（上位20） --}}
    <div class="col-md-6">
      <div class="card border h-100">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
          <h6 class="mb-0 fw-bold">違反報告が多い投稿（上位20）</h6>
          <a href="{{ route('admin.postslist') }}" class="btn btn-sm btn-outline-secondary">もっと見る</a>
        </div>
        <div class="card-body p-0">
          <ul class="list-group list-group-flush">
            @foreach($hotPosts as $p)
              <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                <span class="text-truncate flex-grow-1 me-3" style="max-width:70%">
                  {{ $p->title }}
                </span>
                <span class="badge bg-danger px-2 py-1">{{ $p->reports_count }}</span>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>

    {{-- 違反の多いユーザー（上位10） --}}
    <div class="col-md-6">
      <div class="card border h-100">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
          <h6 class="mb-0 fw-bold">違反の多いユーザー（上位10）</h6>
          <a href="{{ route('admin.userlist') }}" class="btn btn-sm btn-outline-secondary">もっと見る</a>
        </div>
        <div class="card-body p-0">
          <ul class="list-group list-group-flush">
            @foreach($hotUsers as $u)
              <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                <div class="text-truncate flex-grow-1 me-3" style="max-width:70%">
                  <div class="fw-medium">{{ $u->name }}</div>
                  <small class="text-muted">{{ $u->email }}</small>
                </div>
                <span class="badge bg-danger px-2 py-1">{{ $u->post_reports_count }}</span>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.card {
  transition: all 0.2s ease-in-out;
}

.card:hover {
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.list-group-item {
  border-left: none;
  border-right: none;
}

.list-group-item:first-child {
  border-top: none;
}

.list-group-item:last-child {
  border-bottom: none;
}

.badge {
  font-size: 0.75rem;
}
</style>
@endsection
