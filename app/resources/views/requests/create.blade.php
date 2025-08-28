@extends('layouts.app')

@section('content')
  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <!-- 見出し -->
        <div class="d-flex align-items-center mb-4">
          <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-3">
            戻る
          </a>
          <h1 class="h2 fw-bold mb-0">依頼作成</h1>
        </div>

        <!-- 依頼作成フォーム -->
        <div class="card border">
          <div class="card-body p-4">
            {{-- バリデーションエラー表示（最上部） --}}
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form method="POST" action="{{ route('requests.store') }}" novalidate>
              @csrf

              {{-- 内容入力エリア（メイン） --}}
              <div class="mb-4">
                <label class="form-label fw-semibold">依頼内容</label>
                <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="8"
                  placeholder="依頼の詳細を入力してください" required>{{ old('content') }}</textarea>
                @error('content')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- 電話番号 --}}
              <div class="mb-4">
                <label class="form-label fw-semibold">電話番号</label>
                <input type="text" name="tel" class="form-control @error('tel') is-invalid @enderror"
                  value="{{ old('tel') }}" placeholder="09012345678" pattern="[0-9]{10,15}">
                <div class="form-text">ハイフンなしで入力してください</div>
                @error('tel')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- メールアドレス --}}
              <div class="mb-4">
                <label class="form-label fw-semibold">メールアドレス</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                  value="{{ old('email', auth()->user()->email ?? '') }}" placeholder="example@email.com" required>
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- 希望納期 --}}
              <div class="mb-4">
                <label class="form-label fw-semibold">希望納期</label>
                <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror"
                  value="{{ old('due_date') }}" min="{{ date('Y-m-d') }}">
                @error('due_date')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- 対象の投稿（隠しフィールド） --}}
              @if(isset($post))
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <div class="mb-4">
                  <label class="form-label fw-semibold">対象の投稿</label>
                  <div class="form-control-plaintext bg-light p-3">
                    {{ $post->title }}
                  </div>
                </div>
              @else
                <div class="mb-4">
                  <label class="form-label fw-semibold">対象の投稿</label>
                  <select name="post_id" class="form-control @error('post_id') is-invalid @enderror" required>
                    <option value="">選択してください</option>
                    @foreach($posts as $p)
                      <option value="{{ $p->id }}" {{ old('post_id') == $p->id ? 'selected' : '' }}>
                        {{ $p->title }}
                      </option>
                    @endforeach
                  </select>
                  @error('post_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              @endif

              <!-- アクションボタン -->
              <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4">
                  戻る
                </a>
                <button type="submit" class="btn btn-primary px-5">
                  依頼を送信する
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- 追加CSS --}}
  <style>
    .form-control:focus {
      border-color: #0d6efd;
      box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
  </style>
@endsection