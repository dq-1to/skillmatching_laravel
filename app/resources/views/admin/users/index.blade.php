@extends('layouts.app')
@section('content')
<div class="container">
  <h1>ユーザーリスト</h1>

  <form method="GET" class="form-inline mb-3">
    <input type="text" name="q" value="{{ request('q') }}" class="form-control mr-2" placeholder="名前/メール検索">
    <select name="sort" class="form-control mr-2">
      <option value="">新着順</option>
      <option value="reports" {{ request('sort')==='reports'?'selected':'' }}>違反数順</option>
    </select>
    <button class="btn btn-outline-secondary">検索</button>
  </form>

  @foreach($users as $u)
    <div class="card mb-2">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <div class="h5 mb-1">{{ $u->name }}</div>
          <div class="text-muted small">
            {{ $u->email }} / 違反数: {{ $u->post_reports_count }} /
            状態: {{ $u->del_flag ? '停止中' : '有効' }}
          </div>
        </div>
        <form method="POST" action="{{ route('admin.users.toggle',$u) }}">
          @csrf @method('PUT')
          <button class="btn btn-sm {{ $u->del_flag ? 'btn-success' : 'btn-danger' }}">
            {{ $u->del_flag ? '解除' : '停止' }}
          </button>
        </form>
      </div>
    </div>
  @endforeach

  {{ $users->links() }}
</div>
@endsection
