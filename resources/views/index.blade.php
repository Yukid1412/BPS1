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
                        <input type="file" name="image">
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
                    @foreach($thread->images()->get() as $image)
                    <img src="{{$image->image_path}}">
                    @endforeach
                    カテゴリー：{{ $thread->category->name }}<br>
                    <a href="{{ route('thread', $thread->id) }}">品物名：{{ $thread->title }}</a>&nbsp;返信{{ $thread->replies_count }}件
                @endif
                
                </div>

                <div class="card-body">
                @if ($thread->delete_flag == 1)
                この投稿は削除されました。
                @else    
                    {!! nl2br(e($thread->body)) !!}
                @endif
                </div>
                <br>
                @if ($thread->delete_flag == 1)
                @else
               
                    <form class="text-end" action="{{ route('thread_delete') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $thread->id }}">
                        <button type="submit" class="btn btn-danger">削除</button>
                    </form>
                
                @endif
                
            </div>
            <br>
            @endforeach
        </div>
    </div>
</div>
@endsection
