@extends('layouts.app')

@section('content')
<div class="container py-4">

  {{-- 見出しと新規投稿 --}}
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 fw-bold mb-0">投稿一覧</h1>
    @auth
      <a href="{{ route('posts.create') }}" class="btn btn-success px-4">新規投稿</a>
    @else
      <div class="alert alert-info mb-0 py-2 px-3">
        <a href="{{ route('login') }}" class="alert-link">ログイン</a>すると投稿ができます。
      </div>
    @endauth
  </div>

  {{-- 検索フォーム --}}
  <div class="card border mb-4">
    <div class="card-body py-3">
      <form method="GET" action="{{ route('posts.index') }}">
        <div class="row g-3 align-items-end">

          <div class="col-md-3">
            <label class="form-label small text-muted mb-1">タイトル検索</label>
            <input class="form-control" name="title" placeholder="タイトルを入力"
                   value="{{ request('title') }}">
          </div>

          <div class="col-md-2">
            <label class="form-label small text-muted mb-1">最低金額</label>
            <input class="form-control" type="number" name="min" placeholder="0"
                   value="{{ request('min') }}">
          </div>

          <div class="col-md-2">
            <label class="form-label small text-muted mb-1">最高金額</label>
            <input class="form-control" type="number" name="max" placeholder="100000"
                   value="{{ request('max') }}">
          </div>

          <div class="col-md-3">
            <label class="form-label small text-muted mb-1">フリーワード</label>
            <input class="form-control" name="q" placeholder="キーワードを入力"
                   value="{{ request('q') }}">
          </div>

          <div class="col-md-2">
            <button class="btn btn-primary px-4 w-100">検索</button>
          </div>

        </div>
      </form>
    </div>
  </div>

  {{-- 投稿カードグリッド --}}
  <div class="row g-4">
    @forelse($posts as $post)
      <div class="col-12 col-md-6 col-lg-4 mb-4">
        <div class="card h-100 border hover-card">
          {{-- サムネイル --}}
          @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}"
                 alt="投稿画像"
                 class="card-img-top object-fit-cover"
                 style="height:180px;">
          @else
            <div class="bg-light" style="height:180px"></div>
          @endif

          <div class="card-body">
            {{-- タイトル --}}
            <h5 class="fw-bold text-truncate mb-2">
              <a href="{{ route('posts.show', $post) }}" class="text-decoration-none text-dark">
                {{ $post->title }}
              </a>
            </h5>

            {{-- 概要（2行制限） --}}
            <p class="text-muted mb-3 clamp-2">{{ Str::limit($post->content, 90) }}</p>

            {{-- 金額（priceフィールドのみ） --}}
            @if($post->price)
              <div class="fw-semibold text-success mb-3">
                ¥{{ number_format($post->price) }}
              </div>
            @endif

            {{-- 下部操作 --}}
            <div class="d-flex justify-content-between align-items-center">
              @include('partials.bookmark-button', ['post' => $post])
              <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-secondary">
                詳細を見る
              </a>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="alert alert-warning text-center">投稿がありません。</div>
      </div>
    @endforelse
  </div>

  {{-- ページネーション --}}
  <div class="mt-4">
    {{ $posts->links() }}
  </div>
</div>

{{-- 追加CSSでソリッドな印象に調整 --}}
<style>
  .hover-card { 
    transition: transform .15s ease, box-shadow .15s ease; 
  }
  .hover-card:hover { 
    transform: translateY(-1px); 
    box-shadow: 0 4px 12px rgba(0,0,0,.15)!important; 
  }
  .object-fit-cover { object-fit: cover; }
  .clamp-2 {
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden;
  }
</style>
@endsection
