<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskAttribute;
use App\Models\TaskMember;

class TaskController extends Controller
{
    public function getTaskId($id){
        $task = Task::select('id', 'headline', 'description')
        ->with(['attributes' => function ($query) {
            $query->select('id', 'taskId', 'attribute', 'isDone');
        }])
        ->find($id);
    
        if($task == null){
            return response()->json(['errorCode' => '404' , 'errorMessage' => "Not found"], 400);
        }

        $transformedTask = $task->toArray();
        $transformedTask['errorCode'] = "200";
        $transformedTask['errorMessage'] = "Success";

        $transformedTask['attributes'] = $task->attributes->map(function ($attribute) {
            return [
                'id' => $attribute->id,
                'taskId' => $attribute->taskId,
                'attribute' => $attribute->attribute,
                'isDone' => $attribute->isDone,
            ];
        })->toArray();
       
        return response()->json($transformedTask);
    }

    public function createTask(Request $request){
        $request->validate([
            'headline' => 'required|min:6',
            'description' => 'required|min:6',
            'attributes'=> 'required'
        ]);
        try {
            $task = Task::create([
                'headline' => $request->headline,
                'description' => $request->description
            ]);
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage();
            return response()->json(['errorCode' => '400' , 'errorMessage' => $th->getMessage()], 400);
        }
      
        $attributes = json_decode($request->input('attributes'));
        if ($attributes === null && json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['errorCode' => '400' , 'errorMessage' => 'Bad Reqeuest, Attributes must using valid Json Array'] , 400);
        }

        try {
            foreach ($attributes as $attribute) {
                $taskAttribute = TaskAttribute::create([
                    'attribute' => $attribute->attribute,
                    'taskId' => $task->id,
                    'isDone' => '0'
                ]);
            }
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage();
            return response()->json(['errorCode' => '400' , 'errorMessage' => $th->getMessage()] , 400);
        }
        
        $response = [
            'errorCode' => '200',
            'errorMessage' => 'Success',
            'taskId' => $task->id,
            'headline' => $request->headline,
            'description' => $request->description,
            'attributes' => $attributes
        ];
        return response()->json($response);
    }

    public function updateTask($id, Request $request){
        $request->validate([
            'headline' => 'required|min:6',
            'description' => 'required|min:6',
            'attributes' => 'required'
        ]);
        
        try {
            $task = Task::find($id);
            $task->update([
                'headline' => $request->headline,
                'description' => $request->description
            ]);
            $taskAttributeDelete = TaskAttribute::where('taskId' , $id)->delete();
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage();
            return response()->json(['errorCode' => '400' , 'errorMessage' => $th->getMessage()], 400);
        }

        $attributes = json_decode($request->input('attributes'));
        if ($attributes === null && json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['errorCode' => '400' , 'errorMessage' => 'Bad Reqeuest, Attributes must using valid Json Array'] , 400);
        }


        try {
            foreach ($attributes as $attribute) {
                $taskAttribute = TaskAttribute::create([
                    'attribute' => $attribute->attribute,
                    'taskId' => $task->id,
                    'isDone' => '0'
                ]);
            }
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage();
            return response()->json(['errorCode' => '400' , 'errorMessage' => $th->getMessage()] , 400);
        }

        $response = [
            'errorCode' => '200',
            'errorMessage' => 'Success',
            'headline' => $request->headline,
            'description' => $request->description,
            'attributes' => $attributes
        ];
        return response()->json($response);
    }

    public function deleteTask($id){
        $task = Task::where('id',$id)->first();
        try {
            $task->delete();
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage();
            return response()->json(['errorCode' => '400' , 'errorMessage' => $th->getMessage()] , 400);
        }
        return response()->json(['errorCode' => '200' , 'errorMessage' => 'Deleted'],200);

    }

    public function updateTaskAttribute($taskId,$attributeId,Request $request){
        try {
            $taskAttribute = TaskAttribute::where('taskId',$taskId)->Where('id',$attributeId)->first();
            $taskAttribute->update([
                'isDone' => $request->status
            ]);
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage();
            return response()->json(['errorCode' => '400' , 'errorMessage' => $th->getMessage()] , 400);
        }
        return response()->json(['errorCode' => '200' , 'errorMessage' => 'Updated'],200);
    }

    public function deleteTaskAttribute($taskId,$attributeId){
        try {
            $taskAttribute = TaskAttribute::where('taskId',$taskId)->Where('id',$attributeId)->first();
            $taskAttribute->delete();
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage();
            return response()->json(['errorCode' => '400' , 'errorMessage' => $th->getMessage()] , 400);
        }
        return response()->json(['errorCode' => '200' , 'errorMessage' => 'Deleted'],200);
    }

    public function assign($id,Request $request){
        $request->validate([
            'members' => 'required'
        ]);
        $members = json_decode($request->input('members'));

        if ($members === null && json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['errorCode' => '400' , 'errorMessage' => 'Bad Reqeuest, Members must using valid Json Array'] , 400);
        }

        try {
            foreach($members as $member){
                $taskMember = TaskMember::create([
                    'taskId' => $id,
                    'userId' => $member->id
                ]);
            }
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage();
            return response()->json(['errorCode' => '400' , 'errorMessage' => $th->getMessage()] , 400);
        }
        return response()->json(['errorCode'=>'200','errorMessage'=>'Success'],200);

    }
}
