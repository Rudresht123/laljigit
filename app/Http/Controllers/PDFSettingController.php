<?php

namespace App\Http\Controllers;

use App\Models\PDFTemplateModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PDFSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pdfs = PDFTemplateModel::get();
        return view('admin_panel.pdfs_setting.index', compact('pdfs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin_panel.pdfs_setting.pdf_template');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'template_name' => 'required|string|unique:pdf_templates',
            'template_slug' => 'required|unique:pdf_templates',
            'content' => 'required|string',
            'is_active' => 'required'
        ]);


        $newTemplate = new PDFTemplateModel();
        if ($request->hasFile('template_logo')) {
            // Upload the new profile picture
            $file = $request->file('template_logo');
            $path = 'uploads/pdf_logos/';
            $templogo = compressImageToSize($file, $path, 300);
            $newTemplate['template_logo'] = $templogo;
        }

        if ($request->hasFile('template_watermark')) {
            // Upload the new profile picture
            $file = $request->file('template_watermark');
            $path = 'uploads/pdf_logos/';
            $tempWatermark = compressImageToSize($file, $path, 300);
            $newTemplate['template_watermark'] = $tempWatermark;
        }

       $result=$newTemplate->create(
        [
            'template_name'=>$request->input('template_name'),
            'template_slug'=>$request->input('template_slug'),
            'content'=>$request->input('content'),
            'template_logo'=>$templogo ?? null,
            'template_watermark'=>$tempWatermark ?? null,
            'is_active'=>$request->input('is_active'),
        ]
       );
        if ($result) {
            return redirect()->back()->with(['success' => 'Pdf Template Created Successfully Done']);
        } else {
            return redirect()->back()->with(['error' => 'Pdf Template not Created Successfully Done']);
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
        $pdfdata = PDFTemplateModel::find($id);
        return view('admin_panel.pdfs_setting.edit_pdf_template', compact('pdfdata'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'template_name' => 'required|string|unique:pdf_templates,template_name,' . $id,
            'template_slug' => 'required|unique:pdf_templates,template_slug,' . $id,
            'content' => 'required|string',
            'template_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            'template_watermark' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            'is_active' => 'required'
        ]);
        $newTemplate = PDFTemplateModel::findOrFail($id);
        if ($request->hasFile('template_logo')) {
            // Delete the old profile picture if it exists
            if (Storage::disk('public')->exists('uploads/pdf_logos/'.$newTemplate->template_logo)) {
                Storage::disk('public')->delete('uploads/pdf_logos/'.$newTemplate->template_logo);
            }

            // Upload the new profile picture
            $file = $request->file('template_logo');
            $path = 'uploads/pdf_logos/';
            $templogo = compressImageToSize($file, $path, 300);
            $newTemplate['template_logo'] = $templogo;
        }

        if ($request->hasFile('template_watermark')) {
            // Delete the old profile picture if it exists
            if (Storage::disk('public')->exists('uploads/pdf_logos/'.$newTemplate->template_watermark)) {
                Storage::disk('public')->delete('uploads/pdf_logos/'.$newTemplate->template_watermark);
            }

            // Upload the new profile picture
            $file = $request->file('template_watermark');
            $path = 'uploads/pdf_logos/';
            $tempWatermark = compressImageToSize($file, $path, 300);
            $newTemplate['template_watermark'] = $tempWatermark;
        }

       $result=$newTemplate->update(
        [
            'template_name'=>$request->input('template_name'),
            'template_slug'=>$request->input('template_slug'),
            'content'=>$request->input('content'),
            'template_logo'=>$templogo ?? $newTemplate->template_logo,
            'template_watermark'=>$tempWatermark ?? $newTemplate->template_watermark,
            'is_active'=>$request->input('is_active'),
        ]
       );

        if ($result) {
            return redirect()->back()->with(['success' => 'PDF Template updated successfully.']);
        } else {
            return redirect()->back()->with(['error' => 'PDF Template not updated successfully.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $template = PDFTemplateModel::find($id);

        if ($template) {
            $template->delete(); // Delete the template
            return response()->json(['success' => 'PDF Template Deleted Successfully Done']);
        } else {
            return response()->json(['error' => 'PDF Template not Deleted Successfully Done']);
        }
    }
}
