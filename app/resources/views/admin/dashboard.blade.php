@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>管理者ページです</h1>
    
    <!-- デバッグ情報 -->
    
    <div class="d-flex gap-2">
      <a href="{{ route('admin.reports.index') }}" class="btn btn-primary">通報一覧</a>
    </div>
  </div>
@endsection