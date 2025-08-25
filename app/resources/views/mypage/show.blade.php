@extends('layouts.app')
@section('content')
  <div class="container">
    <h1>マイページ</h1>
    <div class="card mb-4">
      <div class="card-body d-flex align-items-center justify-content-between">

        {{-- 左：アイコン --}}
        <div class="d-flex align-items-center">
          @if(auth()->user()->icon)
            <img src="{{ asset('storage/' . auth()->user()->icon) }}" alt="ユーザーアイコン" class="rounded-circle mr-3"
              style="width:80px; height:80px; object-fit:cover;">
          @else
            <div class="rounded-circle bg-secondary mr-3" style="width:80px; height:80px;"></div>
          @endif

          {{-- ユーザー情報 --}}
          <div>
            <h5 class="mb-1">{{ auth()->user()->name }}</h5>
            <p class="mb-0 text-muted">{{ auth()->user()->email }}</p>
          </div>
        </div>

        {{-- 右：ボタン群 --}}
        <div>
          <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary mr-2">ユーザー編集</a>

          <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button class="btn btn-outline-danger">ログアウト</button>
          </form>
        </div>

      </div>
    </div>
    {{-- ① 自分の投稿 --}}
    <div class="mb-4">
      <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">自分の投稿（最新10件）</h4>
        <a href="{{ route('posts.index', ['mine' => 1]) }}" class="btn btn-sm btn-outline-secondary">もっと見る</a>
      </div>
      <ul class="list-group mt-2">
        @forelse($myPosts as $p)
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="{{ route('posts.show', $p) }}">{{ $p->title }}</a>
            <small class="text-muted">
              ¥{{ number_format($p->price) }} / {{ $p->created_at->format('Y-m-d') }}
            </small>
          </li>
        @empty
          <li class="list-group-item text-muted">投稿はありません</li>
        @endforelse
      </ul>
    </div>

    {{-- ② 送信依頼 --}}
    <div class="mb-4">
      <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">送信依頼（最新10件）</h4>
        <a href="{{ route('requests.index', ['box' => 'sent']) }}" class="btn btn-sm btn-outline-secondary">もっと見る</a>
      </div>
      <ul class="list-group mt-2">
        @forelse($sentRequests as $r)
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
              <span class="badge badge-{{ [0 => 'secondary', 1 => 'warning', 2 => 'success'][$r->status] ?? 'secondary' }}">
                {{ [0 => '掲載中', 1 => '進行中', 2 => '完了'][$r->status] ?? '掲載中' }}
              </span>
              <a href="{{ route('requests.show', $r) }}" class="ml-2">
                {{ \Illuminate\Support\Str::limit($r->content, 40) }}
              </a>
              <small class="text-muted d-block">
                対象：{{ optional($r->post)->title ?? '（削除済み）' }}
              </small>
            </div>
            <small class="text-muted">{{ $r->created_at->format('Y-m-d') }}</small>
          </li>
        @empty
          <li class="list-group-item text-muted">送信した依頼はありません</li>
        @endforelse
      </ul>
    </div>

    {{-- ③ 受信依頼 --}}
    <div class="mb-4">
      <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">受信依頼（最新10件）</h4>
        <a href="{{ route('requests.index', ['box' => 'received']) }}" class="btn btn-sm btn-outline-secondary">もっと見る</a>
      </div>
      <ul class="list-group mt-2">
        @forelse($receivedRequests as $r)
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
              <span class="badge badge-{{ [0 => 'secondary', 1 => 'warning', 2 => 'success'][$r->status] ?? 'secondary' }}">
                {{ [0 => '掲載中', 1 => '進行中', 2 => '完了'][$r->status] ?? '掲載中' }}
              </span>
              <a href="{{ route('requests.show', $r) }}" class="ml-2">
                {{ \Illuminate\Support\Str::limit($r->content, 40) }}
              </a>
              <small class="text-muted d-block">
                依頼者：{{ optional($r->user)->name ?? 'Unknown' }} ／ 対象：{{ optional($r->post)->title ?? '（削除済み）' }}
              </small>
            </div>
            <small class="text-muted">{{ $r->created_at->format('Y-m-d') }}</small>
          </li>
        @empty
          <li class="list-group-item text-muted">受信した依頼はありません</li>
        @endforelse
      </ul>
    </div>

    {{-- ④ ブックマーク --}}
    <div class="mb-4">
      <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">ブックマーク（最新10件）</h4>
        <a href="{{ route('posts.index', ['bookmarked' => 1]) }}" class="btn btn-sm btn-outline-secondary">
          もっと見る
        </a>
      </div>

      <ul class="list-group mt-2">
        @forelse($bookmarkedPosts as $bp)
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="{{ route('posts.show', $bp) }}">{{ \Illuminate\Support\Str::limit($bp->title, 40) }}</a>
            <small class="text-muted">
              {{-- ブックマークした日時：pivot 側 --}}
              {{ optional($bp->pivot->created_at)->format('Y-m-d') }}
            </small>
          </li>
        @empty
          <li class="list-group-item text-muted">ブックマークはまだありません</li>
        @endforelse
      </ul>
    </div>

  </div>
@endsection