<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'title',
        'body',
        'category_id',
    ];
    
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    
    public function replies(){
        return $this->hasMany('App\Models\Reply');
    }
   
   public function category(){
        return $this->belongsTo('App\Models\Category');
    }
    
    public function images(){
        return $this->hasMany('App\Models\Image');
    }
}
