@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <!-- 見出し -->
            <div class="text-center mb-4">
                <h1 class="h2 fw-bold mb-2">
                    <i class="bi bi-box-arrow-in-right me-2"></i>ログイン
                </h1>
                <p class="text-muted">アカウントにログインしてください</p>
            </div>

            <!-- ログインフォーム -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

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
                                   autocomplete="email" 
                                   autofocus>

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
                                   placeholder="パスワードを入力"
                                   required 
                                   autocomplete="current-password">

                            @error('password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill">
                                <i class="bi bi-box-arrow-in-right me-2"></i>{{ __('Login') }}
                            </button>
                        </div>

                        <div class="text-center">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link text-decoration-none" href="{{ route('password.request') }}">
                                    <i class="bi bi-question-circle me-1"></i>{{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- 新規登録への誘導 -->
            <div class="text-center mt-4">
                <p class="text-muted mb-0">
                    アカウントをお持ちでない方は
                    <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">新規登録</a>
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
        border-color: #0d6efd; 
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25); 
    }
</style>
@endsection
