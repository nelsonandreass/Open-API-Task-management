<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\TaskMember;
use App\Models\Task;

class UserController extends Controller
{
    public function users(){
        $users = User::select('id','name','email','role')->get();
        return response()->json($users);
    }

    public function tasks($userId){
        $tasks = Task::select('headline','description')->whereHas('members' , function($query) use ($userId){
            $query->where('userId', $userId);
        })->get();

        if($tasks == null) {
            return response()->json(['errorCode' => '404' , 'errorMessage' => "Not found"], 400);
        }
      
        return response()->json(['errorCode' => '200' , 'errorMessage' => "Success" , 'data' => $tasks] , 200);
    }
}
