<?php

namespace App\Http\Controllers;

use App\Models\OfficesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OfficesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offices=OfficesModel::get();
        return view('admin_panel.global_setting.define_office.index',compact('offices'));
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
            'office_name' => 'required|string',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); 
        }
        $newData=new OfficesModel();
        $newData->fill($validator->validated());
      if($newData->save())
      {
        return response()->json(['success'=>'Office Created Successfully Done']);
      }
      else
      {
        return response()->json(['error'=>'Office not Created Successfully Done']);

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
        $office=OfficesModel::find($id);
        return response()->json($office);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'office_name' => 'required|string',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); 
        }
        $newData=OfficesModel::find($id);
        $newData->fill($validator->validated());
      if($newData->save())
      {
        return response()->json(['success'=>'Office updated  Successfully Done']);
      }
      else
      {
        return response()->json(['error'=>'Office not updated Successfully Done']);

      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result=OfficesModel::find($id)->delete();
        if($result)
      {
        return response()->json(['success'=>'Office deleted Successfully Done']);
      }
      else
      {
        return response()->json(['error'=>'Office not deleted Successfully Done']);

      }
    }
}
