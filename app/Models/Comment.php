<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['comment','taskId','userId'];

    public function user(){
        return $this->belongsTo(User::class,'id','userId');
    }
}
