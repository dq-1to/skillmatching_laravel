@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- 戻るボタン -->
                <div class="mb-3">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> 戻る
                    </a>
                </div>

                <!-- 投稿詳細カード -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">{{ $post->title }}</h2>
                    </div>
                    <div class="card-body">
                        <!-- 画像 -->
                        @if($post->image)
                            <div class="text-center mb-3">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="投稿画像" class="img-fluid"
                                    style="max-height: 300px;">
                            </div>
                        @else
                            <div class="text-center mb-3">
                                <img src="{{ asset('images/default.jpg') }}" alt="デフォルト画像" class="img-fluid"
                                    style="max-height: 300px;">
                            </div>
                        @endif

                        <!-- 金額 -->
                        <div class="mb-3">
                            <h4 class="text-primary">¥{{ number_format($post->price) }}</h4>
                        </div>

                        <!-- 内容 -->
                        <div class="mb-4">
                            <h5>内容</h5>
                            {{-- body → content に修正 --}}
                            <p class="card-text">{{ $post->content }}</p>
                        </div>

                        <!-- 投稿情報 -->
                        <div class="row text-muted mb-3">
                            <div class="col-md-6">
                                <small>投稿者: {{ $post->user->name ?? 'Unknown' }}</small>
                            </div>
                            <div class="col-md-6 text-right">
                                <small>投稿日: {{ $post->created_at->format('Y年m月d日 H:i') }}</small>
                            </div>
                        </div>

                        <!-- アクションボタン -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @auth
                                    <!-- 投稿編集ボタン（投稿者のみ表示） -->
                                    @if(auth()->id() === $post->user_id)
                                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning">
                                            <i class="fas fa-edit"></i> 投稿編集
                                        </a>
                                    @endif

                                    @if(auth()->id() !== $post->user_id)
                                        <a href="{{ route('requests.create', ['post' => $post->id]) }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> 依頼を作成
                                        </a>
                                    @endif

                                    <!-- 違反報告ボタン（準備中） -->
                                    <button type="button" class="btn btn-danger" disabled>
                                        <i class="fas fa-flag"></i> 違反報告（準備中）
                                    </button>
                                @else
                                    <!-- 未ログイン時はログインページへ誘導 -->
                                    <div class="alert alert-info">
                                        投稿の編集や依頼作成には<a href="{{ route('login') }}">ログイン</a>が必要です。
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection