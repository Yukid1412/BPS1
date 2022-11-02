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
            
            <button type="button" class="btn btn-secondary" onclick="history.back()">スレッド一覧に戻る</button>
            <br>
            <br>
            
            @guest
            <div class="alert alert-info">
                ログインしていなければ投稿はできません。
            </div>
            @endguest
                    
            @auth
            <div class="card">
                <div class="card-header">リプライ投稿</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('reply_store') }}">
                        @csrf
                        <label for="body" class="col-form-label">内容</label>
                        <textarea id="body" name="body" class="form-control"></textarea>
                        @error('body')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                        <button type="submit" class="btn btn-primary">投稿</button>
                    </form>
                </div>
            </div>    
            <br>
            @endauth
            <div class="card">
                <div class="card-header">
                    ID:{{ $thread->id }}<br>
                    ユーザー：{{ $thread->user->name }}<br>
                    <a href="{{ route('thread', $thread->id) }}">品物：{{ $thread->title }}</a>
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
                @if ($reply->delete_flag == 1)
                この返信は削除されました。
                @else
                <div class="card-body">
                    {!! nl2br(e($reply->body)) !!}
                </div>
                @endif
                @if (Auth::id() == $reply->user_id)
                    @if ($reply->delete_flag == 1)
                    @else
                    <div class="text-end">
                        <form action="{{ route('reply_delete') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $reply->id }}">
                            <button type="submit" class="btn btn-danger">削除</button>
                        </form>
                    </div>
                    @endif
                @endif
            </div>
            <br>
            @endforeach
        </div>
    </div>
</div>
@endsection
