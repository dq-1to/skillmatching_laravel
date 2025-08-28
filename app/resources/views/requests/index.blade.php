@extends('layouts.app')

@section('content')
<div class="container py-4">
  {{-- 見出しとタブ --}}
  <div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 fw-bold mb-0">依頼一覧</h1>
  </div>

  {{-- タブナビゲーション --}}
  <div class="card border mb-4">
    <div class="card-body py-3">
      <div class="nav nav-pills nav-fill">
        <a href="{{ route('requests.index', ['box'=>'sent']) }}" 
           class="nav-link {{ $mode==='sent'?'active':'text-muted' }}">
          送信依頼
        </a>
        <a href="{{ route('requests.index', ['box'=>'received']) }}" 
           class="nav-link {{ $mode==='received'?'active':'text-muted' }}">
          受信依頼
        </a>
      </div>
    </div>
  </div>

  {{-- 依頼カードグリッド --}}
  <div class="row g-4">
    @forelse($requests as $req)
      <div class="col-12 col-md-6 col-lg-4 mb-4">
        <div class="card h-100 border hover-card">
          <div class="card-body">
            {{-- ステータスバッジ --}}
            <div class="mb-3">
              <span class="badge bg-{{ [0=>'secondary',1=>'warning',2=>'success'][$req->status] ?? 'secondary' }} px-3 py-2">
                {{ [0=>'掲載中',1=>'進行中',2=>'完了'][$req->status] ?? '掲載中' }}
              </span>
            </div>

            {{-- 対象投稿タイトル --}}
            <h6 class="fw-bold text-truncate mb-2">
              <span class="text-muted small">対象投稿：</span>
              {{ optional($req->post)->title ?? '（削除済み）' }}
            </h6>

            {{-- 依頼内容（2行制限） --}}
            <p class="text-muted mb-3 clamp-2">
              {{ \Illuminate\Support\Str::limit($req->content, 90) }}
            </p>

            {{-- 作成日時 --}}
            <div class="text-muted small mb-3">
              {{ $req->created_at->format('Y年m月d日 H:i') }}
            </div>

            {{-- 下部操作 --}}
            <div class="d-flex justify-content-between align-items-center">
              <a href="{{ route('requests.show', $req) }}" class="btn btn-outline-secondary">
                詳細を見る
              </a>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="alert alert-info text-center py-5">
          <div class="mb-2">依頼はありません</div>
          <small class="text-muted">
            @if($mode === 'sent')
              まだ依頼を送信していません
            @else
              まだ依頼を受信していません
            @endif
          </small>
        </div>
      </div>
    @endforelse
  </div>

  {{-- ページネーション --}}
  @if($requests->hasPages())
    <div class="d-flex justify-content-center mt-5">
      {{ $requests->links() }}
    </div>
  @endif
</div>

<style>
.hover-card {
  transition: all 0.2s ease-in-out;
}

.hover-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.nav-pills .nav-link.active {
  background-color: #0d6efd;
  color: white;
}

.nav-pills .nav-link:not(.active):hover {
  background-color: #f8f9fa;
  color: #0d6efd;
}
</style>
@endsection
