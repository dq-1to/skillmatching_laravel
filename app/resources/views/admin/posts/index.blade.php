@extends('layouts.app')
@section('content')
<div class="container py-4">
  <h1 class="h3 fw-bold mb-4">投稿管理</h1>

  {{-- 検索・絞り込みフォーム --}}
  <div class="card border mb-4">
    <div class="card-body py-3">
      <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-6">
          <label class="form-label small text-muted mb-1">タイトル/内容検索</label>
          <input type="text" name="q" value="{{ request('q') }}" 
                 class="form-control" placeholder="キーワードを入力">
        </div>
        <div class="col-md-3">
          <label class="form-label small text-muted mb-1">並び順</label>
          <select name="sort" class="form-select">
            <option value="">新着順</option>
            <option value="reports" {{ request('sort')==='reports'?'selected':'' }}>違反数順</option>
          </select>
        </div>
        <div class="col-md-3">
          <button class="btn btn-primary px-4 w-100">検索</button>
        </div>
      </form>
    </div>
  </div>

  {{-- 投稿一覧 --}}
  <div class="row g-4">
    @forelse($posts as $p)
      <div class="col-12">
        <div class="card border hover-card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
              <div class="flex-grow-1 me-3">
                {{-- タイトル --}}
                <h5 class="fw-bold mb-2">{{ $p->title }}</h5>
                
                {{-- 投稿者情報 --}}
                <div class="d-flex align-items-center mb-2">
                  <span class="badge bg-secondary me-2">投稿者</span>
                  <span class="fw-medium">{{ $p->user->name ?? '-' }}</span>
                </div>
                
                {{-- 違反数と状態 --}}
                <div class="d-flex align-items-center gap-3">
                  <div class="d-flex align-items-center">
                    <span class="badge bg-danger me-2">違反数</span>
                    <span class="fw-bold text-danger">{{ $p->reports_count }}</span>
                  </div>
                  <div class="d-flex align-items-center">
                    <span class="badge bg-{{ $p->del_flag ? 'warning' : 'success' }} me-2">状態</span>
                    <span class="fw-medium">{{ $p->del_flag ? '停止中' : '公開中' }}</span>
                  </div>
                </div>
              </div>
              
              {{-- 操作ボタン --}}
              <div class="flex-shrink-0">
                <form method="POST" action="{{ route('admin.posts.toggle',$p) }}">
                  @csrf @method('PUT')
                  <button class="btn {{ $p->del_flag ? 'btn-success' : 'btn-danger' }} px-3">
                    {{ $p->del_flag ? '解除' : '停止' }}
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="alert alert-info text-center py-5">
          <div class="mb-2">投稿が見つかりません</div>
          <small class="text-muted">検索条件を変更してお試しください</small>
        </div>
      </div>
    @endforelse
  </div>

  {{-- ページネーション --}}
  @if($posts->hasPages())
    <div class="d-flex justify-content-center mt-5">
      {{ $posts->links() }}
    </div>
  @endif
</div>

<style>
.hover-card {
  transition: all 0.2s ease-in-out;
}

.hover-card:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.badge {
  font-size: 0.75rem;
}
</style>
@endsection
