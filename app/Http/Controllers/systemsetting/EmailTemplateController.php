<?php

namespace App\Http\Controllers\systemsetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\EmailTemplateModel;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates=EmailTemplateModel::get();
        return view('admin_panel.EmailTemplate.index',compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin_panel.EmailTemplate.addEmailtemplate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=validator::make($request->all(),[
            'name'=>'required|string',
            'slug'=>'required',
            'subject'=>'required',
            'content'=>'nullable',
            'description'=>'nullable',
            'from_name'=>'nullable',
            'from_email'=>'nullable|email',
            'cc_email'=>'nullable|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $template = EmailTemplateModel::create($validator->validated());

        if ($template) {
            return response()->json(['success' => 'Template created successfully.']);
        } else {
            Log::error('Failed to create email template', [
                'request_data' => $request->all(),
            ]);
    
            return response()->json(['error' => 'Template creation failed.']);
        }
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $template=EmailTemplateModel::where('id',$id)->get();
        return view('admin_panel.EmailTemplate.showemailtemplate',compact('template'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $template=EmailTemplateModel::where('id',$id)->first();
       
        return view('admin_panel.EmailTemplate.editEmailTemplate',compact('template'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'content' => 'nullable|string',
            'description' => 'nullable|string|max:255',
            'from_name' => 'nullable|string|max:255',
            'from_email' => 'nullable|email',
            'cc_email' => 'nullable|email'
        ]);
    
        // Find the template by ID
        $template = EmailTemplateModel::find($id);
    
        if (!$template) {
            return redirect()->back()->with(['error' => 'Template not found']);
        }
    
        // Update the template with new data
        $updateData = $request->only([
            'name', 'slug', 'subject', 'content', 'description', 'from_name', 'from_email', 'cc_email'
        ]);
    
        if ($template->update($updateData)) {
            return redirect()->back()->with(['success' => 'Template Updated Successfully']);
        } else {
            return redirect()->back()->with(['error' => 'Template Update Failed']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */

     public function destroy($id)
    {
        $result=EmailTemplateModel::find($id)->delete();
        if($result)
        {
            return response()->json(['success'=>'Email Template Deleted Successfully Done']);
        }
        else
        {
            return response()->json(['success'=>'Email Template not Deleted Successfully Done']);
        }
    }
   
}
