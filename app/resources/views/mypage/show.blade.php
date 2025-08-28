@extends('layouts.app')

@section('content')
<div class="container py-4">
  <!-- 見出し -->
  <h1 class="h2 fw-bold mb-4">マイページ</h1>

  <!-- ユーザー情報セクション（現状から変更なし） -->
  <div class="card border mb-4">
    <div class="card-body d-flex align-items-center justify-content-between">
      {{-- 左：アイコン --}}
      <div class="d-flex align-items-center">
        @if(auth()->user()->icon)
          <img src="{{ asset('storage/' . auth()->user()->icon) }}" alt="ユーザーアイコン" class="rounded-circle me-3"
            style="width:80px; height:80px; object-fit:cover;">
        @else
          <div class="rounded-circle bg-secondary me-3" style="width:80px; height:80px;"></div>
        @endif

        {{-- ユーザー情報 --}}
        <div>
          <h5 class="mb-1">{{ auth()->user()->name }}</h5>
          <p class="mb-0 text-muted">{{ auth()->user()->email }}</p>
        </div>
      </div>

      {{-- 右：ボタン群 --}}
      <div>
        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary me-2">ユーザー編集</a>

        <form method="POST" action="{{ route('logout') }}" class="d-inline">
          @csrf
          <button class="btn btn-outline-danger">ログアウト</button>
        </form>
      </div>
    </div>
  </div>

  <!-- コンテンツブロック（2×2の段組み） -->
  <div class="row g-4">
    {{-- ① 自分の投稿一覧ブロック --}}
    <div class="col-md-6">
      <div class="card border h-100">
        <div class="card-header bg-white border-bottom py-3">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">自分の投稿</h5>
            <a href="{{ route('posts.index', ['mine' => 1]) }}" class="btn btn-sm btn-outline-secondary">もっと見る</a>
          </div>
        </div>
        <div class="card-body p-0">
          <ul class="list-group list-group-flush">
            @forelse($myPosts as $p)
              <li class="list-group-item border-0 py-3">
                <div class="d-flex justify-content-between align-items-start">
                  <div class="flex-grow-1 me-2">
                    <a href="{{ route('posts.show', $p) }}" class="text-decoration-none fw-semibold">
                      {{ \Illuminate\Support\Str::limit($p->title, 30) }}
                    </a>
                    @if($p->price)
                      <div class="text-success small mt-1">¥{{ number_format($p->price) }}</div>
                    @endif
                  </div>
                  <small class="text-muted">{{ $p->created_at->format('m/d') }}</small>
                </div>
              </li>
            @empty
              <li class="list-group-item border-0 py-3 text-muted text-center">
                投稿はありません
              </li>
            @endforelse
          </ul>
        </div>
      </div>
    </div>

    {{-- ② 送信依頼一覧ブロック --}}
    <div class="col-md-6">
      <div class="card border h-100">
        <div class="card-header bg-white border-bottom py-3">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">送信依頼</h5>
            <a href="{{ route('requests.index', ['box' => 'sent']) }}" class="btn btn-sm btn-outline-secondary">もっと見る</a>
          </div>
        </div>
        <div class="card-body p-0">
          <ul class="list-group list-group-flush">
            @forelse($sentRequests as $r)
              <li class="list-group-item border-0 py-3">
                <div class="d-flex justify-content-between align-items-start">
                  <div class="flex-grow-1 me-2">
                    <div class="d-flex align-items-center mb-1">
                      <span class="badge bg-{{ [0 => 'secondary', 1 => 'warning', 2 => 'success'][$r->status] ?? 'secondary' }} me-2">
                        {{ [0 => '掲載中', 1 => '進行中', 2 => '完了'][$r->status] ?? '掲載中' }}
                      </span>
                      <small class="text-muted">{{ $r->created_at->format('m/d') }}</small>
                    </div>
                    <a href="{{ route('requests.show', $r) }}" class="text-decoration-none">
                      {{ \Illuminate\Support\Str::limit($r->content, 40) }}
                    </a>
                    <div class="text-muted small mt-1">
                      対象：{{ \Illuminate\Support\Str::limit(optional($r->post)->title ?? '（削除済み）', 20) }}
                    </div>
                  </div>
                </div>
              </li>
            @empty
              <li class="list-group-item border-0 py-3 text-muted text-center">
                送信した依頼はありません
              </li>
            @endforelse
          </ul>
        </div>
      </div>
    </div>

    {{-- ③ 受信依頼一覧ブロック --}}
    <div class="col-md-6">
      <div class="card border h-100">
        <div class="card-header bg-white border-bottom py-3">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">受信依頼</h5>
            <a href="{{ route('requests.index', ['box' => 'received']) }}" class="btn btn-sm btn-outline-secondary">もっと見る</a>
          </div>
        </div>
        <div class="card-body p-0">
          <ul class="list-group list-group-flush">
            @forelse($receivedRequests as $r)
              <li class="list-group-item border-0 py-3">
                <div class="d-flex justify-content-between align-items-start">
                  <div class="flex-grow-1 me-2">
                    <div class="d-flex align-items-center mb-1">
                      <span class="badge bg-{{ [0 => 'secondary', 1 => 'warning', 2 => 'success'][$r->status] ?? 'secondary' }} me-2">
                        {{ [0 => '掲載中', 1 => '進行中', 2 => '完了'][$r->status] ?? '掲載中' }}
                      </span>
                      <small class="text-muted">{{ $r->created_at->format('m/d') }}</small>
                    </div>
                    <a href="{{ route('requests.show', $r) }}" class="text-decoration-none">
                      {{ \Illuminate\Support\Str::limit($r->content, 40) }}
                    </a>
                    <div class="text-muted small mt-1">
                      依頼者：{{ optional($r->user)->name ?? 'Unknown' }}
                    </div>
                    <div class="text-muted small">
                      対象：{{ \Illuminate\Support\Str::limit(optional($r->post)->title ?? '（削除済み）', 20) }}
                    </div>
                  </div>
                </div>
              </li>
            @empty
              <li class="list-group-item border-0 py-3 text-muted text-center">
                受信した依頼はありません
              </li>
            @endforelse
          </ul>
        </div>
      </div>
    </div>

    {{-- ④ ブックマーク一覧ブロック --}}
    <div class="col-md-6">
      <div class="card border h-100">
        <div class="card-header bg-white border-bottom py-3">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">ブックマーク</h5>
            <a href="{{ route('posts.index', ['bookmarked' => 1]) }}" class="btn btn-sm btn-outline-secondary">
              もっと見る
            </a>
          </div>
        </div>
        <div class="card-body p-0">
          <ul class="list-group list-group-flush">
            @forelse($bookmarkedPosts as $bp)
              <li class="list-group-item border-0 py-3">
                <div class="d-flex justify-content-between align-items-start">
                  <div class="flex-grow-1 me-2">
                    <a href="{{ route('posts.show', $bp) }}" class="text-decoration-none fw-semibold">
                      {{ \Illuminate\Support\Str::limit($bp->title, 30) }}
                    </a>
                    @if($bp->price)
                      <div class="text-success small mt-1">¥{{ number_format($bp->price) }}</div>
                    @endif
                    <div class="text-muted small mt-1">
                      ブックマーク日：{{ optional($bp->pivot->created_at)->format('m/d') }}
                    </div>
                  </div>
                </div>
              </li>
            @empty
              <li class="list-group-item border-0 py-3 text-muted text-center">
                ブックマークはまだありません
              </li>
            @endforelse
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection