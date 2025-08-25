@extends('layouts.app')
@section('content')
<div class="container">
  <h1>依頼を編集</h1>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('requests.update', $req) }}">
        @csrf @method('PUT')

        <div class="form-group">
          <label>対象投稿</label>
          <p class="form-control-plaintext">
            {{ optional($req->post)->title ?? '（削除済み）' }}
          </p>
        </div>

        <div class="form-group">
          <label>依頼内容</label>
          <textarea name="content" class="form-control" rows="6" required>{{ old('content', $req->content) }}</textarea>
        </div>

        <div class="form-group">
          <label>電話番号（ハイフンなし・数字のみ）</label>
          <input type="text" name="tel" class="form-control"
                 value="{{ old('tel', $req->tel) }}" pattern="[0-9]{10,15}">
          <small class="text-muted">例: 09012345678</small>
        </div>

        <div class="form-group">
          <label>メールアドレス</label>
          <input type="email" name="email" class="form-control" value="{{ old('email', $req->email) }}" required>
        </div>

        <div class="form-group">
          <label>納期</label>
          <input type="date" name="due_date" class="form-control"
                 value="{{ old('due_date', optional($req->due_date)->format('Y-m-d')) }}">
        </div>

        <button class="btn btn-primary">更新する</button>
        <a href="{{ route('requests.show', $req) }}" class="btn btn-outline-secondary">戻る</a>
      </form>
    </div>
  </div>
</div>
@endsection
