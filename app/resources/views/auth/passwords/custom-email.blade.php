@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('パスワードリセット') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('reset_link_generated'))
                        <div class="alert alert-info" role="alert">
                            <strong>メールアドレスが確認されました！</strong><br>
                            下記のボタンをクリックしてパスワードリセットページに進んでください。
                        </div>
                        
                        <div class="text-center">
                            <a href="{{ route('password.reset.redirect') }}" class="btn btn-success btn-lg">
                                <i class="fas fa-key mr-2"></i>
                                パスワードリセットページへ進む
                            </a>
                        </div>
                    @else
                        <div class="text-center mb-4">
                            <p class="text-muted">パスワードを忘れた方は、下記にメールアドレスを入力してください。</p>
                        </div>

                        <form method="POST" action="{{ route('password.generate.link') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('メールアドレス') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-envelope mr-2"></i>
                                        パスワードリセットリンクを生成
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif

                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="text-muted">
                            <i class="fas fa-arrow-left mr-1"></i>
                            ログインページに戻る
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
