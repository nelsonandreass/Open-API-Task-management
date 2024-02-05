<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Comment;
use App\Models\User;

class CommentController extends Controller
{
    public function createComment($id,Request $request){
        $request->validate([
            'comment' => 'required|min:2'
        ]);

        try {
            $comment = Comment::create([
                'comment' => $request->comment,
                'taskId' => $id,
                'userId' => Auth::id()
            ]);
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage();
            return response()->json(['errorCode' => '400' , 'errorMessage' => $th->getMessage()] , 400);
        }
        return response()->json(['errorCode' => '200' , 'errorMessage' => "Success" , 'comment' => $request->comment] , 200);
    }

    public function getComment($id){
        $comment = Comment::where('taskId',$id)->get();
        if($comment == null){
            return response()->json(['errorCode' => '404' , 'errorMessage' => "Not Found"] , 403);
        }
        return response()->json($comment, 200);
    }
}
