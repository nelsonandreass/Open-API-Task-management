<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;

class PriorityController extends Controller
{
    public function updatePriority($id , Request $request){
        $request->validate([
            'priority' => 'required'
        ]);
        try {
            $priority = Task::find($id);
            $priority->update([
                'priority' => $request->priority
            ]);
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage();
            return response()->json(['errorCode' => '400' , 'errorMessage' => $th->getMessage()] , 400);
        }
        return response()->json(['errorCode' => '200' , 'errorMessage' => 'Updated' , 'data' => Task::find($id)],200);
    }
}
