<?php

namespace App\Http\Controllers;

use App\Models\MainCategoryModel;
use App\Models\SubcategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategory extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mainCategory=MainCategoryModel::where('status','yes')->get();
        return view('admin_panel.global_setting.sub_category.index',compact('mainCategory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mainCategory=MainCategoryModel::where('status','yes')->get();
        return view('admin_panel.global_setting.sub_category.show',compact('mainCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'main_category_id' => 'required',
        'subcategory' => 'required|string',
        'subcategory_remark' => 'nullable|string',
        'status' => 'required'
    ]);
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()],422);
    }
    $subCategory = new SubcategoryModel();
    $subCategory->fill($validator->validated());
    if ($subCategory->save()) {
        return response()->json(['success' => 'Sub Category Created Successfully']);
    } else {
        return response()->json(['error' =>'Sub Category Not Created']);
    }
}

    /**
     * Display the specified resource.
     */
  public function show(string $id)
{
    $subCategorys = SubcategoryModel::where('main_category_id', $id)->get();
    return response()->json(['data' => $subCategorys], 200);  // Return the data in a structured format
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
     
    $mainCategory=MainCategoryModel::where('status','yes')->get();
        $subCategory = SubcategoryModel::find($id);
        return view('admin_panel.global_setting.sub_category.edit',compact(['subCategory','mainCategory']));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'main_category_id' => 'required',
            'subcategory' => 'required|string',
            'subcategory_remark' => 'nullable|string',
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()],422);
        }
        $subCategory =SubcategoryModel::find($id);
        $subCategory->fill($validator->validated());
        if ($subCategory->update()) {
            return redirect()->back()->with(['success' => 'Sub Category updated Successfully']);
        } else {
            return  redirect()->back()->with(['error' =>'Sub Category Not updated']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result=SubcategoryModel::find($id)->delete();
        if($result){
        return response()->json(['success' => 'Sub Category Deleted Successfully']);
    } else {
        return response()->json(['error' =>'Sub Category Not Deleted Successfully']);
    }
    }
}
