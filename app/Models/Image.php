<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'thread_id',
        'image_path',
    ];
    
    public function thread(){
        return $this->belongsTo('App\Models\Thread');
    }
}
