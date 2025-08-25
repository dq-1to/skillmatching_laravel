@extends('layouts.app')
@section('content')
<div class="container">
  <h1>依頼一覧</h1>

  <div class="mb-3">
    <a href="{{ route('requests.index', ['box'=>'sent']) }}" class="btn btn-sm {{ $mode==='sent'?'btn-primary':'btn-outline-primary' }}">送信依頼</a>
    <a href="{{ route('requests.index', ['box'=>'received']) }}" class="btn btn-sm {{ $mode==='received'?'btn-primary':'btn-outline-primary' }}">受信依頼</a>
  </div>

  @forelse($requests as $req)
    <div class="card mb-2">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div>
            <div class="mb-1">
              <span class="badge badge-{{ [0=>'secondary',1=>'warning',2=>'success'][$req->status] ?? 'secondary' }}">
                {{ [0=>'掲載中',1=>'進行中',2=>'完了'][$req->status] ?? '掲載中' }}
              </span>
            </div>
            <div class="text-muted small mb-1">
              対象投稿：{{ optional($req->post)->title ?? '（削除済み）' }}
            </div>
            <div>{{ \Illuminate\Support\Str::limit($req->content, 100) }}</div>
          </div>
          <div class="text-right text-muted small">
            {{ $req->created_at->format('Y-m-d H:i') }}
          </div>
        </div>
        <div class="mt-2">
          <a href="{{ route('requests.show', $req) }}" class="btn btn-sm btn-outline-secondary">詳細</a>
        </div>
      </div>
    </div>
  @empty
    <div class="alert alert-info">依頼はありません。</div>
  @endforelse

  {{ $requests->links() }}
</div>
@endsection
