@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">SkillMatching</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="mb-3">This page is home page.</p>
                    
                    <div class="d-flex gap-2">
                        <a href="{{ route('posts.index') }}" class="btn btn-primary">投稿一覧</a>
                        <a href="{{ route('posts.create') }}" class="btn btn-success">新規投稿</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
