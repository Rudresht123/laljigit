<?php

namespace App\Http\Controllers\gloalsetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeallerModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class DeallerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin_panel.global_setting.deal_with.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        
        $validator = Validator::make($request->all(), [
            'dealler_name' => 'required|string',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); 
        }
        $newstatus=new DeallerModel();
        $newstatus->fill($validator->validated());
      if($newstatus->save())
      {
        return response()->json(['success'=>'Dealler Created Successfully Done']);
      }
      else
      {
        return response()->json(['error'=>'Dealler is not Created Successfully Done']);

      }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $Dealler=DeallerModel::find($id);
        return response()->json($Dealler);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'dealler_name' => 'required|string',
            'status' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
    
        // Find the record first
        $updateStatus = DeallerModel::find($id);
    
        if (!$updateStatus) {
            return response()->json([
                'error' => 'Dealler  not found'
            ], 404);  // Return a 404 if the record isn't found
        }
    
        // Update the status
        $updateStatus->fill($validator->validated());
    
        if ($updateStatus->save()) {  // Using save() instead of update() to handle new updates
            return response()->json(['success' => 'Dealler  updated successfully']);
        } else {
            return response()->json(['error' => 'Dealler  update failed']);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Dealler = DeallerModel::find($id);

        if($Dealler){
            if($Dealler->delete()){  // Using save() instead of update() to handle new updates
                return response()->json(['success' => 'Dealler  deleted successfully']);
            } else {
                return response()->json(['error' => 'Dealler  not deleted successfully']);
            }
        }
        else{
            return response()->json(['error' => 'Dealler  not Find successfully']);
        }
    }
}
