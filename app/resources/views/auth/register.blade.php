@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <!-- 見出し -->
            <div class="text-center mb-4">
                <h1 class="h2 fw-bold mb-2">
                    <i class="bi bi-person-plus me-2"></i>新規登録
                </h1>
                <p class="text-muted">新しいアカウントを作成してください</p>
            </div>

            <!-- 新規登録フォーム -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">
                                <i class="bi bi-person me-1"></i>{{ __('Name') }}
                            </label>
                            <input id="name" 
                                   type="text" 
                                   class="form-control form-control-lg rounded-3 @error('name') is-invalid @enderror" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="お名前を入力してください"
                                   required 
                                   autocomplete="name" 
                                   autofocus>

                            @error('name')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">
                                <i class="bi bi-envelope me-1"></i>{{ __('E-Mail Address') }}
                            </label>
                            <input id="email" 
                                   type="email" 
                                   class="form-control form-control-lg rounded-3 @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="example@email.com"
                                   required 
                                   autocomplete="email">

                            @error('email')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">
                                <i class="bi bi-lock me-1"></i>{{ __('Password') }}
                            </label>
                            <input id="password" 
                                   type="password" 
                                   class="form-control form-control-lg rounded-3 @error('password') is-invalid @enderror" 
                                   name="password" 
                                   placeholder="パスワードを入力してください"
                                   required 
                                   autocomplete="new-password">

                            @error('password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-semibold">
                                <i class="bi bi-lock-fill me-1"></i>{{ __('Confirm Password') }}
                            </label>
                            <input id="password-confirm" 
                                   type="password" 
                                   class="form-control form-control-lg rounded-3" 
                                   name="password_confirmation" 
                                   placeholder="パスワードを再入力してください"
                                   required 
                                   autocomplete="new-password">
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill">
                                <i class="bi bi-person-plus me-2"></i>{{ __('Register') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ログインへの誘導 -->
            <div class="text-center mt-4">
                <p class="text-muted mb-0">
                    すでにアカウントをお持ちの方は
                    <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">ログイン</a>
                    してください
                </p>
            </div>
        </div>
    </div>
</div>

{{-- 追加CSS --}}
<style>
    .rounded-4 { border-radius: 1rem !important; }
    .form-control:focus { 
        border-color: #198754; 
        box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25); 
    }
</style>
@endsection
