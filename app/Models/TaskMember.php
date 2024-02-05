<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskMember extends Model
{
    use HasFactory;

    protected $fillable = ['taskId','userId'];

    public function task(){
        return $this->belongsTo(Task::class , 'taskId' , 'id');
    }
}
