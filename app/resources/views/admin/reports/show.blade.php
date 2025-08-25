@extends('layouts.app')
@section('content')
<div class="container">
  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
  <h1>通報詳細</h1>
  <div class="card mb-3">
    <div class="card-body">
      <p><strong>投稿：</strong><a href="{{ route('posts.show',$report->post) }}">{{ $report->post->title }}</a></p>
      <p><strong>通報者：</strong>{{ $report->reporter->name }}</p>
      <p><strong>内容：</strong></p>
      <pre style="white-space:pre-wrap">{{ $report->reason }}</pre>

      <form method="POST" action="{{ route('admin.reports.update',$report) }}" class="form-inline">
        @csrf @method('PUT')
        <select name="status" class="form-control mr-2">
          <option value="0" {{ $report->status==0?'selected':'' }}>報告済</option>
          <option value="1" {{ $report->status==1?'selected':'' }}>対応完了</option>
        </select>
        <button class="btn btn-primary">更新</button>
      </form>

      <form method="POST" action="{{ route('admin.reports.destroy',$report) }}" class="mt-3">
        @csrf @method('DELETE')
        <button class="btn btn-outline-danger" onclick="return confirm('削除しますか？')">削除</button>
      </form>
    </div>
  </div>
</div>
@endsection
