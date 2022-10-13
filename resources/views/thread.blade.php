@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
            <div class="card">
                <div class="card-header">リプライ投稿</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('reply_store') }}">
                        @csrf
                        <label for="body" class="col-form-label">内容</label>
                        <textarea id="body" name="body" class="form-control"></textarea>
                        
                        <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                        <button type="submit" class="btn btn-primary">投稿</button>
                    </form>
                </div>
            </div>    
            <br>
            <div class="card">
                <div class="card-header">
                    ID:{{ $thread->id }}<br>
                    ユーザー：{{ $thread->user->name }}<br>
                    <a href="{{ route('thread', $thread->id) }}">条件名：{{ $thread->title }}</a>
                </div>

                <div class="card-body">
                    {!! nl2br(e($thread->body)) !!}
                </div>
            </div>
            <br>
            @foreach ($thread->replies as $reply)
            <div class="card">
                <div class="card-header">
                    ユーザー：{{ $reply->user->name }}<br>
                </div>
                
                <div class="card-body">
                    {!! nl2br(e($reply->body)) !!}
                </div>
            </div>
            <br>
            @endforeach
        </div>
    </div>
</div>
@endsection
