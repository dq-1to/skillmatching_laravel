@extends('layouts.app')
@section('content')
<div class="container py-4">
  <h1 class="h3 fw-bold mb-4">通報一覧</h1>

  {{-- 絞り込みフォーム --}}
  <div class="card border mb-4">
    <div class="card-body py-3">
      <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-4">
          <label class="form-label small text-muted mb-1">ステータス</label>
          <select name="status" class="form-select">
            <option value="">すべて</option>
            <option value="0" {{ request('status')==='0'?'selected':'' }}>報告済</option>
            <option value="1" {{ request('status')==='1'?'selected':'' }}>対応完了</option>
          </select>
        </div>
        <div class="col-md-4">
          <button class="btn btn-primary px-4 w-100">絞り込み</button>
        </div>
      </form>
    </div>
  </div>

  {{-- 通報一覧 --}}
  <div class="row g-4">
    @forelse($reports as $r)
      <div class="col-12">
        <div class="card border hover-card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
              <div class="flex-grow-1 me-3">
                {{-- ステータスと理由 --}}
                <div class="d-flex align-items-center mb-2">
                  <span class="badge bg-{{ $r->status === 1 ? 'success' : 'warning' }} me-2">
                    {{ ['報告済','対応完了'][$r->status] }}
                  </span>
                  <span class="fw-medium">
                    {{ \Illuminate\Support\Str::limit($r->reason, 100) }}
                  </span>
                </div>
                
                {{-- 投稿情報 --}}
                <div class="d-flex align-items-center mb-2">
                  <span class="badge bg-secondary me-2">投稿</span>
                  <span class="fw-medium">{{ $r->post->title ?? '-' }}</span>
                </div>
                
                {{-- 通報者情報 --}}
                <div class="d-flex align-items-center">
                  <span class="badge bg-info me-2">通報者</span>
                  <span class="fw-medium">{{ $r->reporter->name ?? '-' }}</span>
                </div>
              </div>
              
              {{-- 日時 --}}
              <div class="flex-shrink-0 text-end">
                <div class="text-muted small mb-1">通報日時</div>
                <div class="fw-medium">{{ $r->created_at->format('Y年m月d日 H:i') }}</div>
                <a href="{{ route('admin.reports.show', $r) }}" class="btn btn-outline-secondary btn-sm mt-2">
                  詳細を見る
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="alert alert-info text-center py-5">
          <div class="mb-2">通報が見つかりません</div>
          <small class="text-muted">絞り込み条件を変更してお試しください</small>
        </div>
      </div>
    @endforelse
  </div>

  {{-- ページネーション --}}
  @if($reports->hasPages())
    <div class="d-flex justify-content-center mt-5">
      {{ $reports->links() }}
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
