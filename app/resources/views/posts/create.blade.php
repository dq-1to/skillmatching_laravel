@extends('layouts.app')
@section('content')
<div class="container">
  <h1>新規投稿</h1>

  {{-- バリデーションエラー表示 --}}
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
      <label>タイトル</label>
      <input name="title" class="form-control" value="{{ old('title') }}" required>
    </div>

    <div class="form-group">
      <label>本文</label>
      {{-- body → content に修正 --}}
      <textarea name="content" class="form-control" rows="6" required>{{ old('content') }}</textarea>
    </div>

    <div class="form-group">
      <label>金額</label>
      <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
    </div>

    <div class="form-group">
      <label>画像</label>
      <input type="file" name="image" class="form-control-file">
    </div>

    <button class="btn btn-primary">投稿</button>
  </form>
</div>
@endsection
