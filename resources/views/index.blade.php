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
            
            @guest
            <div class="alert alert-info">
                ログインしていなければ投稿はできません。
            </div>
            @endguest
            
            @auth        
            <div class="card">
                <div class="card-header">スレッド投稿</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('thread_store') }}" enctype="multipart/form-data">
                        @csrf
                        @foreach($categories as $category)
                        <label>
                        <input type="radio" name="category_id" value= "{{$category->id}}">{{ $category->name }}</label>
                        @endforeach
                        <br>
                        <input type="file" name="images[]" multiple>
                        <br>
                        <label for="title" class="col-form-label">品物名（アクスタ、シール等）</label>
                        <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}">
                        @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <label for="body" class="col-form-label">内容</label>
                        <textarea id="body" name="body" class="form-control">{{ old('body') }}</textarea>
                        @error('body')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="btn btn-primary">投稿</button>
                    </form>
                </div>
            </div>    
            <br>
            @endauth
            
            @foreach($threads as $thread)
            <div class="card">
                <div class="card-header">
                    ID:{{ $thread->id }}<br>
                    ユーザー：{{ $thread->user->name }}<br>
                @if($thread->delete_flag == 1)
                    品物名：削除
                @else
                    カテゴリー：{{ $thread->category->name }}<br>
                    <a href="{{ route('thread', $thread->id) }}">品物名：{{ $thread->title }}</a>&nbsp;　返信{{ $thread->replies->count() }}件
                    <br>
                    @foreach($thread->images()->get() as $image)
                    <img src="{{$image->image_path}}" width="408" height="300">
                    @endforeach
                    <br>
                @endif
                
                </div>

                <div class="card-body">
                @if ($thread->delete_flag == 1)
                この投稿は削除されました。
                @else    
                    {!! nl2br(e($thread->body)) !!}
                    <br>
                    <br>
                    <span>
                    <!-- もし$niceがあれば＝ユーザーが「いいね」をしていたら -->
                    @auth
                    @if(Auth::user()->marks->where('thread_id',$thread->id)->first())
                    <!-- 「いいね」取消用ボタンを表示 -->
	                    <a href="{{ route('unmark', $thread) }}" class="btn btn-success btn-sm">
	                        お気に入り　{{ $thread->mark->count() }}
	                    </a>
                    @else
                    <!-- まだユーザーが「いいね」をしていなければ、「いいね」ボタンを表示 -->
	                    <a href="{{ route('mark', $thread) }}" class="btn btn-outline-secondary btn-sm">
	                        お気に入り　{{ $thread->mark->count() }}
	                    </a>
                    @endif
                    @endauth
                    </span>
                @endif
                </div>
                @if ($thread->delete_flag !== 1)
                    @if (Auth::id() == $thread->user_id)
                    <form class="text-end" action="{{ route('thread_delete') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $thread->id }}">
                        <button type="submit" class="btn btn-danger">削除</button>
                    </form>
                    @endif
                @endif
                
            </div>
            <br>
            @endforeach
        </div>
    </div>
</div>
@endsection
