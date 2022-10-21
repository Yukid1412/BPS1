<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImagesController extends Controller
{
    public function add()
  {
      return view('posts.create');
  }

  public function create(Request $request)
  {
      $image = new Image;
      $form = $request->all();

      //s3アップロード開始
      $image = $request->file('image');
      // バケットの`myprefix`フォルダへアップロード
      $path = Storage::disk('s3')->putFile('myprefix', $image, 'public');
      // アップロードした画像のフルパスを取得
      $image->image_path = Storage::disk('s3')->url($path);

      $image->save();

      return redirect('posts/create');
  }
  
  public function index(Request $request)
  {
      $posts = Post::all();
      return view('posts.index', ['posts' => $posts]);
  }
}
