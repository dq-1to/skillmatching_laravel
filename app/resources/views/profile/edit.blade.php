@extends('layouts.app')
@section('content')
<div class="container">
  <h1>プロフィール編集</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="card mb-4">
    <div class="card-body">
      <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="form-group">
          <label>名前</label>
          <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
          <label>メールアドレス</label>
          <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
          <label>アイコン</label><br>
          @if($user->icon)
            <img src="{{ asset('storage/'.$user->icon) }}" alt="icon" style="width:80px;height:80px;object-fit:cover;" class="mb-2">
          @endif
          <input type="file" name="icon" class="form-control-file">
        </div>

        <hr>

        <div class="form-group">
          <label>新しいパスワード（任意）</label>
          <input type="password" name="password" class="form-control" placeholder="8文字以上">
        </div>
        <div class="form-group">
          <label>新しいパスワード（確認）</label>
          <input type="password" name="password_confirmation" class="form-control">
        </div>

        <button class="btn btn-primary">更新する</button>
        <a href="{{ route('mypage.show') }}" class="btn btn-outline-secondary">マイページへ戻る</a>
      </form>
    </div>
  </div>

  <div class="card border-danger">
    <div class="card-body">
      <h5 class="text-danger">退会（アカウントの無効化）</h5>
      <p class="mb-2">退会するとアカウントは無効化されます（再開には管理者対応が必要です）。</p>
      <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('本当に退会しますか？');">
        @csrf @method('DELETE')
        <div class="form-group">
          <label class="mr-2">確認のため <code>DELETE</code> と入力してください</label>
          <input type="text" name="confirm" class="form-control" style="max-width:200px;">
        </div>
        <button class="btn btn-danger">退会する</button>
      </form>
    </div>
  </div>
</div>
@endsection
