<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;

class StatusController extends Controller
{

    public function updateStatus($id,Request $request){
        $request->validate([
            'status' => 'required'
        ]);

        try {
            $status = Task::find($id);
            $status->update([
                'status' => $request->status
            ]);
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage();
            return response()->json(['errorCode' => '400' , 'errorMessage' => $th->getMessage()] , 400);
        }
        return response()->json(['errorCode' => '200' , 'errorMessage' => 'Updated' , 'data' => Task::find($id)],200);
    }
}
