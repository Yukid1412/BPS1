<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Reply;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $threads = Thread::withCount('replies')->get();
        $categories = Category::get();
        
        return view('index', ['threads' => $threads, 'categories' => $categories]);
    }
    
    public function thread_store(Request $request){
        $request->validate([
            'title'=>'required',
            'body'=>'required',
            ]);
        
        $thread = new Thread();
        $thread->user_id = Auth::id();
        $thread->category_id = $request->category_id;
        $thread->title = $request->title;
        $thread->body = $request->body;
        $thread->save();
        
        $image = new Image;

        //s3アップロード開始
        $image1 = $request->file('image');
        //バケットの`myprefix`フォルダへアップロード
        $path = Storage::disk('s3')->putFile('/', $image1, 'public');
        // アップロードした画像のフルパスを取得
        $image->image_path = Storage::disk('s3')->url($path);
        $image->thread_id = $thread->id;
        $image->save();
        
        return redirect(route('index'));
    }
    
    
    public function thread(Thread $thread){
        if ($thread->delete_flag == 1){
            return view('deleted_thread');
        }else{
            return view('thread', ['thread' => $thread]);
        }
    }
    
    public function reply_store(Request $request){
        $request->validate([
            'body'=>'required',
            ]);
        
        $reply = new Reply();
        $reply->thread_id = $request->thread_id;
        $reply->user_id = Auth::id();
        $reply->body = $request->body;
        $reply->save();
        
        return redirect(route('thread', $request->thread_id));
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();

        $user->categories()->detach();
        $user->categories()->attach($request->category);
    }
    
}
