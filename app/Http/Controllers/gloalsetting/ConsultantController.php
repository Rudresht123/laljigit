<?php

namespace App\Http\Controllers\gloalsetting;

use App\Http\Controllers\Controller;
use App\Models\ConsultantModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ConsultantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin_panel.global_setting.consultant.index');
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
            'consultant_name' => 'required|string',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); 
        }
        $newstatus=new ConsultantModel();
        $newstatus->fill($validator->validated());
      if($newstatus->save())
      {
        return response()->json(['success'=>'Consultant Created Successfully Done']);
      }
      else
      {
        return response()->json(['error'=>'Consultant is not Created Successfully Done']);

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
        $Consultant=ConsultantModel::find($id);
        return response()->json($Consultant);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'consultant_name' => 'required|string',
            'status' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
    
        // Find the record first
        $updateStatus = ConsultantModel::find($id);
    
        if (!$updateStatus) {
            return response()->json([
                'error' => 'Consultant  not found'
            ], 404);  // Return a 404 if the record isn't found
        }
    
        // Update the status
        $updateStatus->fill($validator->validated());
    
        if ($updateStatus->save()) {  // Using save() instead of update() to handle new updates
            return response()->json(['success' => 'Consultant  updated successfully']);
        } else {
            return response()->json(['error' => 'Consultant  update failed']);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $consultant = ConsultantModel::find($id);

        if($consultant){
            if($consultant->delete()){  // Using save() instead of update() to handle new updates
                return response()->json(['success' => 'Consultant  deleted successfully']);
            } else {
                return response()->json(['error' => 'Consultant  not deleted successfully']);
            }
        }
        else{
            return response()->json(['error' => 'Consultant  not Find successfully']);
        }
    }
}
