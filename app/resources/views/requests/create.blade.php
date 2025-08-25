@extends('layouts.app')

@section('content')
<div class="container">
  <h1>依頼作成</h1>

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

  <form method="POST" action="{{ route('requests.store') }}">
    @csrf

    {{-- 紐づく投稿 --}}
    <div class="form-group">
      <label>対象の投稿</label>
      @if(isset($post))
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <p class="form-control-plaintext">{{ $post->title }}</p>
      @else
        <select name="post_id" class="form-control" required>
          <option value="">選択してください</option>
          @foreach($posts as $p)
            <option value="{{ $p->id }}" {{ old('post_id') == $p->id ? 'selected' : '' }}>
              {{ $p->title }}
            </option>
          @endforeach
        </select>
      @endif
    </div>

    {{-- 依頼内容 --}}
    <div class="form-group">
      <label>依頼内容</label>
      <textarea name="content" class="form-control" rows="6" required>{{ old('content') }}</textarea>
    </div>

    {{-- 電話番号 --}}
    <div class="form-group">
      <label>電話番号（ハイフンなし）</label>
      <input type="text" name="tel" class="form-control" value="{{ old('tel') }}" pattern="[0-9]{10,15}">
      <small class="form-text text-muted">例: 09012345678</small>
    </div>

    {{-- メールアドレス --}}
    <div class="form-group">
      <label>メールアドレス</label>
      <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email ?? '') }}" required>
    </div>

    {{-- 納期 --}}
    <div class="form-group">
      <label>納期</label>
      <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}">
    </div>

    <button type="submit" class="btn btn-primary">依頼を送信する</button>
  </form>
</div>
@endsection
