<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskAttribute extends Model
{
    use HasFactory;
    
    protected $fillable = ['attribute','taskId','isDone'];

    public function task(){
        return $this->belongsTo(Task::class);
    }
}
