<?php

namespace App\Http\Controllers\systemsetting;

use App\Http\Controllers\Controller;
use App\Models\FormFieldModel;
use App\Models\MainCategoryModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category=MainCategoryModel::get();
        return view('admin_panel.systemsetting.form',compact('category'));
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
        Log::info($request->all());
    
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:main_category,id',
            'field_label' => 'required|string|max:255',
            'field_name' => 'required|string|max:255|unique:category_form',
            'field_type' => 'required|in:text,textarea,select,radio,checkbox,file,date,email,number,',
            'field_options' => 'nullable|json', // Validate as JSON if applicable
            'is_required' => 'boolean',
            'field_order' => 'integer|min:0',
        ]);
    
        // Check for validation errors
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
    
        // Create a new form field after validation passes
        $newField = FormFieldModel::create($validator->validated());
    
        // Check if the field was created successfully
        if ($newField) {
            return response()->json(['success' => 'Field Created Successfully']);
        } else {
            return response()->json(['error' => 'Field not Created Successfully'], 500); // Return 500 for server errors
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
