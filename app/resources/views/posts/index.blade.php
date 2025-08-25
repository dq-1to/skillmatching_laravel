@extends('layouts.app')
@section('content')
  <div class="container">
    <h1>投稿一覧</h1>

    {{-- 検索フォーム --}}
    <form method="GET" class="mb-3">
      <div class="form-row">
        <input class="form-control col mr-2" name="title" placeholder="タイトル" value="{{ request('title') }}">
        <input class="form-control col mr-2" name="min" type="number" placeholder="最低金額" value="{{ request('min') }}">
        <input class="form-control col mr-2" name="max" type="number" placeholder="最高金額" value="{{ request('max') }}">
        <input class="form-control col mr-2" name="q" placeholder="フリーワード" value="{{ request('q') }}">
        <button class="btn btn-primary col-auto">検索</button>
      </div>
    </form>

    {{-- 投稿ボタン or ログイン案内 --}}
    @auth
      <a href="{{ route('posts.create') }}" class="btn btn-success mb-3">新規投稿</a>
    @else
      <div class="alert alert-info mb-3">
        <a href="{{ route('login') }}" class="alert-link">ログイン</a>すると投稿ができます。
      </div>
    @endauth

    {{-- 投稿一覧 --}}
    @if($posts->count() > 0)
      @foreach($posts as $post)
        <div class="card mb-2">
          <div class="card-body d-flex">
            {{-- 画像があればサムネ表示 --}}
            @if($post->image)
              <img src="{{ asset('storage/' . $post->image) }}" alt="投稿画像" class="mr-3"
                style="width:100px; height:100px; object-fit:cover;">
            @endif

            <div>
              <h5 class="card-title">
                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
              </h5>
              @foreach($posts as $post)
                <div class="card mb-2">
                  <div class="card-body d-flex justify-content-between">
                    <div>
                      <h5><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h5>
                      <p class="mb-0">{{ Str::limit($post->content, 100) }}</p>
                    </div>
                    @include('partials.bookmark-button', ['post' => $post])
                  </div>
                </div>
              @endforeach
              <div class="text-muted">
                ¥{{ number_format($post->price) }} |
                投稿者: {{ $post->user->name ?? 'Unknown' }} |
                {{ $post->created_at->format('Y-m-d H:i') }}
              </div>
              <p class="mb-0">{{ \Illuminate\Support\Str::limit($post->content, 120) }}</p>
            </div>
          </div>
        </div>
      @endforeach

      {{-- ページネーション --}}
      {{ $posts->links() }}
    @else
      <div class="alert alert-warning">
        投稿がありません。
      </div>
    @endif
  </div>
@endsection