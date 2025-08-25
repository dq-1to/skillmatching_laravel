@extends('layouts.app')
@section('content')
    <div class="container">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div> @endif
        <h1>通報内容</h1>
        <div class="card">
            <div class="card-body">
                <p><strong>対象投稿：</strong>
                    @if($report->post && (int)$report->post->del_flag === 0)
                        <a href="{{ route('posts.show', $report->post) }}">
                            {{ $report->post->title }}
                        </a>
                    @else
                        <span class="text-muted">（投稿は削除済み / 存在しません）</span>
                    @endif
                </p>
                <p><strong>ステータス：</strong>{{ ['報告済', '対応完了'][$report->status] }}</p>
                <hr>
                <pre class="mb-0" style="white-space:pre-wrap">{{ $report->reason }}</pre>
            </div>
        </div>
        <div class="d-flex gap-2">
                <a href="{{ route('posts.index') }}" class="btn btn-primary">戻る</a>
            </div>
    </div>
@endsection