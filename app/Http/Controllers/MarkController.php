<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Mark;
use Illuminate\Support\Facades\Auth;

class MarkController extends Controller
{
    public function mark(Thread $thread, Request $request){
        $mark=new Mark();
        $mark->thread_id=$thread->id;
        $mark->user_id=Auth::user()->id;
        $mark->save();
        return back();
    }
    
    public function unmark(Thread $thread, Request $request){
        $user=Auth::user()->id;
        $mark=Mark::where('user_id', $user)->first();
        $mark->delete();
        return back();
    }
}
