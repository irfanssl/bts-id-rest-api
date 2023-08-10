<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Checklist;
use App\Models\User;

class ChecklistController extends Controller
{

      /**
     * success respond
     * @return json
     */
    private function success($data, $message = null){
        return response()
            ->json([
                'code'      => 200,
                'message'   => $message,
                'data'      => $data
            ], 200);
    }

    /**
     * not found respond
     * @return json
    */
    private function notFound($data = null, $message = null){
        return response()
            ->json([
                'code'      => 404,
                'message'   => $message ? $message : 'data not found',
                'data'      => $data
            ], 404);
    }


    public function getChecklist(){
        $data = Checklist::with('checklistItems')->paginate(10);
        return $this->success($data);
    }


    public function createChecklist(Request $request){
       
        $validator = Validator::make(request()->all(), [
            'name' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json(['message' => $validator->messages()]);
        }

        $checklist = Checklist::create([
            'name' => $request->name,
            'created_by' => auth()->user()->id
        ]);

        return $this->success($checklist, 'Create success');
    }


    public function deleteChecklist($checklistId){
        $checklist =  Checklist::where('id', $checklistId)->first();
        if($checklist){
            $checklist->forceDelete();
            return $this->success($checklist, 'Delete success');
        }else{
            return $this->notFound();
        }
    }
}