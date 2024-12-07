<?php

namespace App\Http\Controllers\gloalsetting;

use App\Http\Controllers\Controller;
use App\Models\ExcelColumnNameModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class ExcelColumnNameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tableColumns = Schema::getColumnListing('trademark_users'); 
        $columnName = ExcelColumnNameModel::pluck('column_name')->toArray();
        $newcolumnname = !empty($columnName) ? array_diff($tableColumns, $columnName) : $tableColumns;
        
        if($newcolumnname){
        return view('admin_panel.global_setting.excelcolumn_name.index', compact('newcolumnname','columnName'));
    }
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
            'column_name' => 'required|string',
            'excelcolumn_name'=> 'required|string',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); 
        }
        $newstatus=new ExcelColumnNameModel();
        $newstatus->fill($validator->validated());
      if($newstatus->save())
      {
        return response()->json(['success'=>'ExcelColumn Created Successfully Done']);
      }
      else
      {
        return response()->json(['error'=>'ExcelColumn is not Created Successfully Done']);

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
        $excelcolumn=ExcelColumnNameModel::find($id);
        return response()->json($excelcolumn);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'column_name' => 'required|string',
            'excelcolumn_name' => 'required|string',
            'status' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
    
        // Find the record first
        $updateStatus = ExcelColumnNameModel::find($id);
    
        if (!$updateStatus) {
            return response()->json([
                'error' => 'ExcelColumn  not found'
            ], 404);  // Return a 404 if the record isn't found
        }
    
        // Update the status
        $updateStatus->fill($validator->validated());
    
        if ($updateStatus->save()) {  // Using save() instead of update() to handle new updates
            return response()->json(['success' => 'ExcelColumn  updated successfully']);
        } else {
            return response()->json(['error' => 'ExcelColumn  update failed']);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $consultant = ExcelColumnNameModel::find($id);

        if($consultant){
            if($consultant->delete()){  // Using save() instead of update() to handle new updates
                return response()->json(['success' => 'ExcelColumn  deleted successfully']);
            } else {
                return response()->json(['error' => 'ExcelColumn  not deleted successfully']);
            }
        }
        else{
            return response()->json(['error' => 'ExcelColumn  not Find successfully']);
        }
    }
}

