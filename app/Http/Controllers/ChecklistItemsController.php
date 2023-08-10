<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Checklist;
use Illuminate\Support\Facades\Validator;
use App\Models\ChecklistItems;

class ChecklistItemsController extends Controller
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


    public function getChecklistItem(){
        $data = ChecklistItems::with('checklist')->paginate(10);
        return $this->success($data);
    }


    public function createChecklistItem(Request $request, $checklistId){
        $validator = Validator::make(request()->all(), [
            'itemName' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json(['message' => $validator->messages()]);
        }
        $checklistId = Checklist::where('id', $checklistId)->first();
        if($checklistId) {
            $checklistItem = ChecklistItems::create([
                'item_name' => $request->itemName,
                'checklist_id' => $checklistId->id,
                'created_by' => auth()->user()->id
            ]);
    
            return $this->success($checklistItem, 'Create success');
        }

    }

    public function getItem($checklistId, $itemId){
        $checklist = Checklist::where('id', $checklistId)->first();
        $item = ChecklistItems::where('id', $itemId)->first();
        if($checklist && $item){
            $data = ChecklistItems::with('checklist')
                                ->where('id', $itemId)
                                ->paginate(10);
            return $this->success($data);
        }else{
            return $this->notFound();
        }
    }


    public function updateItem(Request $request, $checklistId, $itemId){
        $checklist = Checklist::where('id', $checklistId)->first();
        $item = ChecklistItems::where('id', $itemId)->first();

        if($checklist && $item){
           $item = ChecklistItems::where('id', $itemId)
                                    ->update([
                                        'checklist_id' => $checklist->id,
                                    ]);
            return $this->success($item, 'Update success');
        }else{
            return $this->notFound();
        }
    }


    public function deleteItem(Request $request, $checklistId, $itemId){
        $checklist =  Checklist::where('id', $checklistId)->first();
        $item = ChecklistItems::where('id', $itemId)->first();
        if($checklist && $item){
            $item->forceDelete();
            return $this->success($item, 'Delete success');
        }else{
            return $this->notFound();
        }
    }


    public function renameItem(Request $request, $checklistId, $itemId){
        $validator = Validator::make($request->all(), [
            'itemName' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json(['message' => $validator->messages()]);
        }

        $checklist =  Checklist::where('id', $checklistId)->first();
        $item = ChecklistItems::where('id', $itemId)->first();
        if($checklist && $item){
            $item = ChecklistItems::where('id', $itemId)
                                    ->update([
                                        'item_name' => $request->itemName
                                    ]);
            return $this->success($item, 'Rename success');
        }else{
            return $this->notFound();
        }
    }
}