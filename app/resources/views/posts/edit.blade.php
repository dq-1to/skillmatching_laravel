@extends('layouts.app')
@section('content')
<div class="container">
  <h1>{{ isset($post) ? '投稿を編集' : '新規投稿' }}</h1>

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

  <form method="POST" action="{{ isset($post) ? route('posts.update',$post) : route('posts.store') }}" enctype="multipart/form-data">
    @csrf
    @if(isset($post)) @method('PUT') @endif

    <div class="form-group">
      <label>タイトル</label>
      <input name="title" class="form-control" value="{{ old('title', $post->title ?? '') }}" required>
    </div>

    <div class="form-group">
      <label>本文</label>
      {{-- body → content に修正 --}}
      <textarea name="content" class="form-control" rows="6" required>{{ old('content', $post->content ?? '') }}</textarea>
    </div>

    <div class="form-group">
      <label>金額</label>
      <input type="number" name="price" class="form-control" value="{{ old('price', $post->price ?? '') }}" required>
    </div>

    <div class="form-group">
      <label>画像</label><br>
      {{-- すでに画像がある場合はプレビュー表示 --}}
      @if(isset($post) && $post->image)
        <div class="mb-2">
          <img src="{{ asset('storage/'.$post->image) }}" alt="投稿画像" style="width:150px; height:auto; object-fit:cover;">
        </div>
      @endif
      <input type="file" name="image" class="form-control-file">
    </div>

    <button class="btn btn-primary">{{ isset($post) ? '更新' : '作成' }}</button>
  </form>
</div>
@endsection
