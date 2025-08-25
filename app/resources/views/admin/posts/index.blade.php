@extends('layouts.app')
@section('content')
<div class="container">
  <h1>投稿リスト</h1>

  <form method="GET" class="form-inline mb-3">
    <input type="text" name="q" value="{{ request('q') }}" class="form-control mr-2" placeholder="タイトル/内容検索">
    <select name="sort" class="form-control mr-2">
      <option value="">新着順</option>
      <option value="reports" {{ request('sort')==='reports'?'selected':'' }}>違反数順</option>
    </select>
    <button class="btn btn-outline-secondary">検索</button>
  </form>

  @foreach($posts as $p)
    <div class="card mb-2">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <div class="h5 mb-1">{{ $p->title }}</div>
          <div class="text-muted small">
            投稿者: {{ $p->user->name ?? '-' }} / 違反数: {{ $p->reports_count }} /
            状態: {{ $p->del_flag ? '停止中' : '公開中' }}
          </div>
        </div>
        <form method="POST" action="{{ route('admin.posts.toggle',$p) }}">
          @csrf @method('PUT')
          <button class="btn btn-sm {{ $p->del_flag ? 'btn-success' : 'btn-danger' }}">
            {{ $p->del_flag ? '解除' : '停止' }}
          </button>
        </form>
      </div>
    </div>
  @endforeach

  {{ $posts->links() }}
</div>
@endsection
