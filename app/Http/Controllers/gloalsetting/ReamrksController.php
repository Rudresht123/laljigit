<?php

namespace App\Http\Controllers\gloalsetting;
use App\Http\Controllers\Controller;
use App\Models\RemarksModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReamrksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin_panel.global_setting.remarks.index');
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
            'remarks' => 'required|string',
            'is_active' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); 
        }

        $newRemark=new RemarksModel();
        $newRemark->fill($validator->validated());

        if($newRemark->save())
        {
            return response()->json(['success'=>'Remarks Created Successfully Done']);
        }
        else{
            return response()->json(['success'=>'Remarks not Created Successfully Done']);
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
        $remarks=RemarksModel::find($id);
        return response()->json($remarks);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'remarks' => 'required|string',
            'is_active' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); 
        }

        $newRemark = RemarksModel::find($id);

        if ($newRemark) {
            $newRemark->fill($validator->validated());
        
            if ($newRemark->update()) {
                return response()->json(['success' => 'Remarks updated successfully.']);
            } else {
                return response()->json(['error' => 'Failed to update remarks.']);
            }
        } else {
            return response()->json(['error' => 'Remarks not found.']);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result=RemarksModel::find($id)->delete();
        if($result)
        {
            return response()->json(['success'=>'Remarks Deleted Successfully Done']);
        }
        else{
            return response()->json(['error'=>'Remarks Not  Deleted Successfully Done']);
        }
    }
}
