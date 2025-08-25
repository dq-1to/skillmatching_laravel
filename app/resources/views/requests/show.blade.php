@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>依頼詳細</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <span
                        class="badge badge-{{ [0 => 'secondary', 1 => 'warning', 2 => 'success'][$req->status] ?? 'secondary' }}">
                        {{ [0 => '掲載中', 1 => '進行中', 2 => '完了'][$req->status] ?? '掲載中' }}
                    </span>
                </div>
                <small class="text-muted">{{ $req->created_at->format('Y-m-d H:i') }}</small>
            </div>

            <div class="card-body">
                <div class="mb-2">
                    <strong>対象投稿：</strong>
                    @if($req->post)
                        <a href="{{ route('posts.show', $req->post) }}">{{ $req->post->title }}</a>
                        <span class="text-muted small">（投稿者: {{ optional($req->post->user)->name ?? 'Unknown' }}）</span>
                    @else
                        <span class="text-muted">（削除済み）</span>
                    @endif
                </div>

                <div class="mb-3">
                    <strong>依頼者：</strong> {{ optional($req->user)->name ?? 'Unknown' }}
                </div>

                <div class="mb-3">
                    <strong>依頼内容</strong>
                    <p class="mt-2 mb-0">{{ $req->content }}</p>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4"><strong>電話</strong><br>{{ $req->tel ?? '-' }}</div>
                    <div class="col-md-4"><strong>メール</strong><br>{{ $req->email }}</div>
                    <div class="col-md-4">
                        <strong>納期</strong><br>{{ $req->due_date ? \Carbon\Carbon::parse($req->due_date)->format('Y-m-d') : '-' }}
                    </div>
                </div>

                @auth
                    @php
                        $isRequester = (int) $req->user_id === (int) auth()->id();     // 依頼者本人？
                        $isRecipient = $req->post && (int) $req->post->user_id === (int) auth()->id(); // 受信者（投稿者）？
                      @endphp

                    {{-- 受信者はステータス更新、依頼者は編集/削除を表示 --}}
                    @if($isRecipient)
                        <hr>
                        <form method="POST" action="{{ route('requests.update', $req) }}" class="form-inline">
                            @csrf @method('PUT')
                            <label class="mr-2 mb-2">ステータス更新</label>
                            <select name="status" class="form-control mr-2 mb-2" required>
                                <option value="0" {{ $req->status == 0 ? 'selected' : '' }}>掲載中</option>
                                <option value="1" {{ $req->status == 1 ? 'selected' : '' }}>進行中</option>
                                <option value="2" {{ $req->status == 2 ? 'selected' : '' }}>完了</option>
                            </select>
                            <button class="btn btn-primary mb-2">更新</button>
                        </form>
                    @endif

                    @if($isRequester)
                        <hr>
                        <div class="d-flex">
                            <a href="{{ route('requests.edit', $req) }}" class="btn btn-warning mr-2">
                                <i class="fas fa-edit"></i> 依頼を編集
                            </a>

                            <form method="POST" action="{{ route('requests.destroy', $req) }}"
                                onsubmit="return confirm('本当に削除しますか？');" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i> 依頼を削除
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        </div>

        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">戻る</a>
    </div>
@endsection