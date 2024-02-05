<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['headline','description','status','priority','categoryId'];

    public function attributes(){
        return $this->hasMany(TaskAttribute::class , 'taskId','id');
    }

    public function members(){
        return $this->hasMany(TaskMember::class , 'taskId','id');
    }

    public function comments(){
        return $this->hasMany(Comment::class , 'taskId','id');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
