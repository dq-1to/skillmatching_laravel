@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- 見出し -->
            <div class="d-flex align-items-center mb-4">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-3">
                    戻る
                </a>
                <h1 class="h2 fw-bold mb-0">依頼詳細</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success mb-4">{{ session('success') }}</div>
            @endif

            <!-- 依頼詳細カード -->
            <div class="card border">
                <div class="card-header bg-white border-bottom py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center text-muted small">
                            <span>作成日: {{ $req->created_at->format('Y年m月d日 H:i') }}</span>
                        </div>
                        <!-- ステータス表示（右上） -->
                        <div>
                            <span class="badge bg-{{ [0 => 'secondary', 1 => 'warning', 2 => 'success'][$req->status] ?? 'secondary' }} px-3 py-2">
                                {{ [0 => '掲載中', 1 => '進行中', 2 => '完了'][$req->status] ?? '掲載中' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- 対象投稿 -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-2">対象投稿</h5>
                        @if($req->post)
                            <div class="bg-light p-3">
                                <a href="{{ route('posts.show', $req->post) }}" class="text-decoration-none">
                                    {{ $req->post->title }}
                                </a>
                                <div class="text-muted small mt-1">
                                    投稿者: {{ optional($req->post->user)->name ?? 'Unknown' }}
                                </div>
                            </div>
                        @else
                            <div class="bg-light p-3 text-muted">（削除済み）</div>
                        @endif
                    </div>

                    <!-- 依頼者 -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-2">依頼者</h5>
                        <div class="bg-light p-3">
                            {{ optional($req->user)->name ?? 'Unknown' }}
                        </div>
                    </div>

                    <!-- 依頼内容（メイン） -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-2">依頼内容</h5>
                        <div class="bg-light p-3">
                            {{ $req->content }}
                        </div>
                    </div>

                    <!-- 連絡先情報 -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <h6 class="fw-bold mb-2">電話番号</h6>
                            <div class="bg-light p-3">
                                {{ $req->tel ?? '-' }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-bold mb-2">メールアドレス</h6>
                            <div class="bg-light p-3">
                                {{ $req->email }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-bold mb-2">希望納期</h6>
                            <div class="bg-light p-3">
                                {{ $req->due_date ? \Carbon\Carbon::parse($req->due_date)->format('Y年m月d日') : '-' }}
                            </div>
                        </div>
                    </div>

                    @auth
                        @php
                            $isRequester = (int) $req->user_id === (int) auth()->id();     // 依頼者本人？
                            $isRecipient = $req->post && (int) $req->post->user_id === (int) auth()->id(); // 受信者（投稿者）？
                        @endphp

                        <!-- 受信者はステータス更新 -->
                        @if($isRecipient)
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">ステータス更新</h6>
                                <form method="POST" action="{{ route('requests.update', $req) }}" class="d-flex gap-3">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="form-select" style="width: auto;" required>
                                        <option value="0" {{ $req->status == 0 ? 'selected' : '' }}>掲載中</option>
                                        <option value="1" {{ $req->status == 1 ? 'selected' : '' }}>進行中</option>
                                        <option value="2" {{ $req->status == 2 ? 'selected' : '' }}>完了</option>
                                    </select>
                                    <button class="btn btn-primary">更新</button>
                                </form>
                            </div>
                        @endif

                        <!-- 依頼者は編集/削除 -->
                        @if($isRequester)
                            <div class="d-flex gap-3">
                                <a href="{{ route('requests.edit', $req) }}" class="btn btn-warning px-4">
                                    依頼を編集
                                </a>

                                <form method="POST" action="{{ route('requests.destroy', $req) }}"
                                    onsubmit="return confirm('本当に削除しますか？');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger px-4">
                                        依頼を削除
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 追加CSS --}}
<style>
    .badge {
        font-size: 0.875rem;
    }
</style>
@endsection