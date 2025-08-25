@extends('layouts.app')
@section('content')
<div class="container">
  <h1>違反報告</h1>
  <div class="card mb-3">
    <div class="card-body">
      <div class="mb-2"><strong>対象投稿：</strong>{{ $post->title }}</div>
      <form method="POST" action="{{ route('reports.store') }}">
        @csrf
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <div class="form-group">
          <label>通報理由</label>
          <textarea name="reason" class="form-control" rows="6" required>{{ old('reason') }}</textarea>
        </div>
        <button class="btn btn-danger">送信する</button>
        <a href="{{ route('posts.show',$post) }}" class="btn btn-outline-secondary">戻る</a>
      </form>
    </div>
  </div>
</div>
@endsection
