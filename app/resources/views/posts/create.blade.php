@extends('layouts.app')

@section('content')
  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <!-- 見出し -->
        <div class="d-flex align-items-center mb-4">
          <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary me-3">
            戻る
          </a>
          <h1 class="h2 fw-bold mb-0">新規投稿</h1>
        </div>

        <!-- 投稿フォーム -->
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

            <form method="POST" action="{{ route('posts.store') }}" novalidate>
              @csrf

              <div class="row">
                <!-- 左側：画像アップロード -->
                <div class="col-md-5">
                  <div class="mb-4">
                    <label class="form-label fw-semibold">画像</label>
                    <div class="border border-dashed p-4 text-center" style="min-height: 200px;">
                      <p class="text-muted small mb-2">画像をドラッグ&ドロップ</p>
                      <p class="text-muted small">または</p>
                      <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                        accept="image/*">
                      <div class="form-text mt-2">JPG、PNG、GIF形式の画像ファイル</div>
                    </div>
                    @error('image')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <!-- 右側：入力フィールド -->
                <div class="col-md-7">
                  <div class="mb-4">
                    <label class="form-label fw-semibold">タイトル</label>
                    <input name="title" class="form-control form-control-lg @error('title') is-invalid @enderror"
                      value="{{ old('title') }}" placeholder="投稿のタイトルを入力してください" required>
                    @error('title')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="mb-4">
                    <label class="form-label fw-semibold">金額</label>
                    <input type="number" name="price"
                      class="form-control form-control-lg @error('price') is-invalid @enderror" value="{{ old('price') }}"
                      placeholder="金額を入力してください" min="0" required>
                    @error('price')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="mb-4">
                    <label class="form-label fw-semibold">内容</label>
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="8"
                      placeholder="投稿の詳細を入力してください" required>{{ old('content') }}</textarea>
                    @error('content')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>

              <!-- アクションボタン -->
              <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary px-4">
                  キャンセル
                </a>
                <button type="submit" class="btn btn-success px-5">
                  投稿する
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
      border-color: #198754;
      box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
    }
  </style>
@endsection