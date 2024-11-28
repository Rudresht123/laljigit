<?php

namespace App\Http\Controllers\gloalsetting;

use App\Http\Controllers\Controller;
use App\Models\MainCategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MainCategory extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin_panel.global_setting.mainCategory.index');
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
        Log::info($request->input('category_slug'));
        $Validator=Validator::make($request->all(),[
            'category_name'=>'required|string',
            'remark'=>'required|string',
            'status'=>'required',
              'category_icon' => 'nullable|file|mimes:jpg,png,jpeg,gif|max:5048',
            'category_slug'=>'required|string'
            
        ]);

        if($Validator->fails())
        {
            return response()->json([
                'errors'=>$Validator->errors()
            ],422);
        }

        if($request->hasFile('category_icon'))
        {
            $file=$request->file('category_icon');
            $directory="uploads/category_icon/";
            $fileName=compressImageToSize($file, $directory, 100);
        }

        $MainCategory=MainCategoryModel::create([
            'category_name'=>$request->input('category_name'),
            'remark'=>$request->input('remark'),
            'status'=>$request->input('status'),
            'category_slug'=>$request->input('category_slug'),
            'category_icon'=>$fileName
        ]);


        if($MainCategory)
        {
            return response()->json(['success'=>'Main Category Created Successfully Done']);
        }
        else{
            return response()->json(['error'=>'Main Category not Created Successfully Done']);
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
        $category=MainCategoryModel::find($id);
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        $Validator=Validator::make($request->all(),[
            'category_name'=>'required|string',
            'remark'=>'required|string',
            'status'=>'required',
           'category_icon' => 'nullable|file|mimes:jpg,png,jpeg,gif|max:5048',
            'category_slug'=>'required|string'
        ]);

        if($Validator->fails())
        {
            return response()->json([
                'errors'=>$Validator->errors()
            ],422);
        }


        $MainCategory=MainCategoryModel::find($id);
        if($request->hasFile('category_icon')) {
            // Get the old file name
            $oldFileName = $MainCategory->category_icon;
        
            // Check if the old file exists and delete it
            if ($oldFileName && Storage::disk('public')->exists($oldFileName)) {
                Storage::disk('public')->delete($oldFileName);
            }
        
            // Handle new file upload
            $file = $request->file('category_icon');
            $directory = "uploads/category_icon/";
            $fileName = compressImageToSize($file, $directory, 100); 
        
            // Update with new file name
            $result= $MainCategory->update([
                'category_name' => $request->input('category_name'),
                'remark' => $request->input('remark'),
                'status' => $request->input('status'),
                'category_slug' => $request->input('category_slug'),
                'category_icon' => $fileName // Set the new file name
            ]);
        } else {
            // Update without changing the file
            $result=$MainCategory->update([
                'category_name' => $request->input('category_name'),
                'remark' => $request->input('remark'),
                'status' => $request->input('status'),
                'category_slug' => $request->input('category_slug')
                // No need to update 'category_icon' if no new file is uploaded
            ]);
        }
        


        if($result)
        {
            return response()->json(['success'=>'Main Category updated Successfully Done']);
        }
        else{
            return response()->json(['error'=>'Main Category not updated Successfully Done']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result=MainCategoryModel::find($id)->delete();
        
        if($result)
        {
            return response()->json(['success'=>'Main Category deleted Successfully Done']);
        }
        else{
            return response()->json(['error'=>'Main Category not deleted Successfully Done']);
        }
    }
}
