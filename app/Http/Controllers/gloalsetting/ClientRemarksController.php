<?php

namespace App\Http\Controllers\gloalsetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClientRemarksModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
class ClientRemarksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin_panel.global_setting.client_remarks.index');
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
            'client_remarks' => 'required|string',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); 
        }

        $newRemark=new ClientRemarksModel();
        $newRemark->fill($validator->validated());

        if($newRemark->save())
        {
            return response()->json(['success'=>'Client Remarks Created Successfully Done']);
        }
        else{
            return response()->json(['success'=>'Client Remarks not Created Successfully Done']);
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
        $remarks=ClientRemarksModel::find($id);
        return response()->json($remarks);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Log::info($request->all());
        $validator = Validator::make($request->all(), [
            'client_remarks' => 'required|string',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); 
        }

        $updatedRemarks = ClientRemarksModel::find($id);

        if ($updatedRemarks) {
            $updatedRemarks->fill($validator->validated());
        
            if ($updatedRemarks->update()) {
                return response()->json(['success' => 'Client Remarks updated successfully.']);
            } else {
                return response()->json(['error' => 'Failed to update Client remarks.']);
            }
        } else {
            return response()->json(['error' => 'Client Remarks not found.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $result=ClientRemarksModel::find($id)->delete();
        if($result)
        {
            return response()->json(['success'=>'CLient Remarks Deleted Successfully Done']);
        }
        else{
            return response()->json(['error'=>'Client Remarks Not  Deleted Successfully Done']);
        }
    }
}
