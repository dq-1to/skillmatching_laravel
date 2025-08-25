@extends('layouts.app')
@section('content')
<div class="container">
  <h1>通報一覧</h1>
  <form method="GET" class="form-inline mb-2">
    <select name="status" class="form-control">
      <option value="">すべて</option>
      <option value="0" {{ request('status')==='0'?'selected':'' }}>報告済</option>
      <option value="1" {{ request('status')==='1'?'selected':'' }}>対応完了</option>
    </select>
    <button class="btn btn-outline-secondary ml-2">絞り込み</button>
  </form>

  @foreach($reports as $r)
    <div class="card mb-2">
      <div class="card-body d-flex justify-content-between">
        <div>
          <strong>[{{ ['報告済','対応完了'][$r->status] }}]</strong>
          <a href="{{ route('admin.reports.show', $r) }}">{{ \Illuminate\Support\Str::limit($r->reason, 50) }}</a>
          <div class="text-muted small">投稿: {{ $r->post->title ?? '-' }} / 通報者: {{ $r->reporter->name ?? '-' }}</div>
        </div>
        <div class="text-muted small">{{ $r->created_at->format('Y-m-d H:i') }}</div>
      </div>
    </div>
  @endforeach

  {{ $reports->links() }}
</div>
@endsection
