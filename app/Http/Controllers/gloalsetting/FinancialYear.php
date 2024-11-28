<?php

namespace App\Http\Controllers\gloalsetting;

use App\Http\Controllers\Controller;
use App\Models\FinancialYearModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class FinancialYear extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin_panel.session.index');
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
                'financial_session' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'is_active'=>'nullable'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422); 
            }
            $newData=new FinancialYearModel();
            $newData->fill($validator->validated());
            if($request->input('is_active'))
            {
                FinancialYearModel::query()->update(['is_active' => 'no']);
            }
            $newData->is_active = $request->input('is_active') ? 'yes' : 'no';

          if($newData->save())
          {
            return response()->json(['success'=>'Financial Year Created Successfully Done']);
          }
          else
          {
            return response()->json(['error'=>'Financial Year not Created Successfully Done']);

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
        $financialyear=FinancialYearModel::find($id);
        return response()->json($financialyear);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $validator = Validator::make($request->all(), [
            'financial_session' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'is_active'=>'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); 
        }
        $newData=FinancialYearModel::find($id);
        $newData->fill($validator->validated());
        if($request->input('is_active'))
        {
            FinancialYearModel::query()->update(['is_active' => 'no']);
        }
        $newData->is_active = $request->input('is_active') ? 'yes' : 'no';

      if($newData->update())
      {
        return response()->json(['success'=>'Financial Year updated Successfully Done']);
      }
      else
      {
        return response()->json(['error'=>'Financial Year not updated Successfully Done']);

      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result=FinancialYearModel::find($id)->delete();
        if($result)
        {
            return response()->json(['success'=>'Financial Year Deleted Successfully Done']);
        }
        else{
            return response()->json(['error'=>'Financial Not Year Deleted Successfully Done']);
        }
    }
}
