@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- 戻るボタン -->
            <div class="mb-4">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                    戻る
                </a>
            </div>

            <!-- 投稿詳細カード -->
            <div class="card border overflow-hidden">
                <!-- ヘッダー部分 -->
                <div class="card-header bg-white border-bottom py-4">
                    <div class="d-flex flex-column">
                        <!-- タイトル（端まで行く） -->
                        <h1 class="h2 fw-bold mb-3">{{ $post->title }}</h1>
                        
                        <!-- 投稿者情報とアクションボタン（一段下げて配置） -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center text-muted small">
                                <span>{{ $post->user->name ?? 'Unknown' }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $post->created_at->format('Y年m月d日 H:i') }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                @include('partials.bookmark-button', ['post' => $post])
                                @auth
                                    <!-- 違反報告ボタン -->
                                    <a href="{{ route('reports.create', ['post' => $post->id]) }}" class="btn btn-outline-danger btn-sm">
                                        違反報告
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <!-- 画像とテキスト情報のレイアウト -->
                    <div class="row g-0">
                        <!-- 左側：画像 -->
                        <div class="col-md-5">
                            @if($post->image)
                                <div class="p-4">
                                    <img src="{{ asset('storage/' . $post->image) }}" 
                                         alt="投稿画像" 
                                         class="img-fluid w-100"
                                         style="max-height: 400px; object-fit: cover;">
                                </div>
                            @else
                                <div class="p-4">
                                    <div class="bg-light d-flex align-items-center justify-content-center"
                                         style="height: 300px;">
                                        <span class="text-muted">画像なし</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <!-- 右側：テキスト情報 -->
                        <div class="col-md-7">
                            <div class="p-4">
                                <!-- 金額表示（priceフィールドのみ） -->
                                @if($post->price)
                                    <div class="mb-4">
                                        <h5 class="text-muted mb-2">金額</h5>
                                        <div class="h3 fw-bold text-success mb-0">
                                            ¥{{ number_format($post->price) }}
                                        </div>
                                    </div>
                                @endif

                                <!-- 内容 -->
                                <div class="mb-4">
                                    <h5 class="fw-bold mb-3">詳細</h5>
                                    <div class="card-text lh-lg">{{ $post->content }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- アクションボタン -->
                    <div class="px-4 pb-4">
                        <div class="d-flex flex-wrap gap-3 justify-content-center">
                            @auth
                                <!-- 投稿編集ボタン（投稿者のみ表示） -->
                                @if(auth()->id() === $post->user_id)
                                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning px-4">
                                        投稿編集
                                    </a>
                                @endif

                                <!-- 依頼作成ボタン（投稿者以外のみ表示） -->
                                @if(auth()->id() !== $post->user_id)
                                    <a href="{{ route('requests.create', ['post' => $post->id]) }}" class="btn btn-primary px-4">
                                        依頼を作成
                                    </a>
                                @endif
                            @else
                                <!-- 未ログイン時はログインページへ誘導 -->
                                <div class="alert alert-info mb-0">
                                    投稿の編集や依頼作成には<a href="{{ route('login') }}" class="alert-link">ログイン</a>が必要です。
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 追加CSS --}}
<style>
    .lh-lg { line-height: 1.8 !important; }
</style>
@endsection