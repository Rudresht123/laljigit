<?php

namespace App\Http\Controllers;

use App\Models\StatusModel;
use App\Models\SubStatusModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SubStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mainStatus=StatusModel::where('status','yes')->get();
        return view('admin_panel.global_setting.define_status.showsubstatus',compact('mainStatus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mainStatus=StatusModel::where('status','yes')->get();
        return view('admin_panel.global_setting.define_status.substatus',compact('mainStatus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      
        $validator=Validator::make($request->all(),[
            'main_status_id'=>'required',
            'substatus_name'=>'required|string',
            'slug'=>'required|string',
            'substatus_remarks'=>'nullable|string',
            'status'=>'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'errors'=>$validator->errors()
            ],422);
        }

        $validatedData = $validator->validated();
        foreach ($validatedData as $key => $value) {
            if ($value === null) {
                $validatedData[$key] = '';
            }
        }

        $newSubStatus=new SubStatusModel();
        $newSubStatus->fill($validatedData);

        if($newSubStatus->save()){
            return response()->json(['success'=>'Sub Status Created Successfully Done']);
        }
        else{
            return response()->json(['errors'=>'Sub Status not Created Successfully Done']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subStatus=SubStatusModel::where('main_status_id',$id)->get();
        if($subStatus){
            return response()->json(['data' => $subStatus], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $substatus=SubStatusModel::find($id);
        $mainStatus=StatusModel::where('status','yes')->get();
        return view('admin_panel.global_setting.define_status.editsubstatus',compact('mainStatus','substatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
  
        $validator=Validator::make($request->all(),[
            'main_status_id'=>'required',
            'substatus_name'=>'required|string',
            'slug'=>'required|string',
            'substatus_remarks'=>'nullable|string',
            'status'=>'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'errors'=>$validator->errors()
            ],422);
        }

        $validatedData = $validator->validated();
        foreach ($validatedData as $key => $value) {
            if ($value === null) {
                $validatedData[$key] = '';
            }
        }

        $newSubStatus=SubStatusModel::find($id);
        $newSubStatus->fill($validatedData);

        if($newSubStatus->update()){
            return redirect()->back()->with(['success'=>'Sub Status updated Successfully Done']);
        }
        else{
            return redirect()->back()->with(['error'=>'Sub Status not updated Successfully Done']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
  public function destroy(string $id)
{
    $status = SubStatusModel::find($id);

    if (!$status) {
        return response()->json(['error' => 'Sub Status not found'], 404);
    }

    if ($status->delete()) {
        return response()->json(['success' => 'Sub Status deleted successfully'], 200);
    }

    return response()->json(['error' => 'Failed to delete Sub Status'], 500);
}

}
