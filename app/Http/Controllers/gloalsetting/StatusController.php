<?php

namespace App\Http\Controllers\gloalsetting;

use App\Http\Controllers\Controller;
use App\Models\StatusModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin_panel.global_setting.define_status.index');
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
            'status_name' => 'required|string',
            'slug' => 'required|string',
            'remark' => 'nullable|string',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); 
        }
        $newstatus=new StatusModel();
        $newstatus->fill($validator->validated());
      if($newstatus->save())
      {
        return response()->json(['success'=>'Status Created Successfully Done']);
      }
      else
      {
        return response()->json(['error'=>'Status is not Created Successfully Done']);

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
        $status=StatusModel::find($id);
        return response()->json($status);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'status_name' => 'required|string',
            'slug'=>'required|string',  
            'remark' => 'required|string',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); 
        }
        $newstatus=StatusModel::find($id);
        $newstatus->fill($validator->validated());
      if($newstatus->save())
      {
        return response()->json(['success'=>'Status updated Successfully Done']);
      }
      else
      {
        return response()->json(['error'=>'Status is not updated Successfully Done']);

      }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result=StatusModel::find($id)->delete();
        if($result)
        {
            return response()->json(['success'=>'Status Deleted Successfully Done']);
        }
        else{
            return response()->json(['error'=>'Status Not  Deleted Successfully Done']);
        }
    }
}
