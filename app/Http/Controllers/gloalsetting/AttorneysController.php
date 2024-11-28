<?php

namespace App\Http\Controllers\gloalsetting;

use App\Http\Controllers\Controller;
use App\Models\AttorneysModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AttorneysController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attroneys=AttorneysModel::orderBy('created_at','desc')->get();
        return view('admin_panel.attorneys.index',compact('attroneys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin_panel.attorneys.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      
        $validator = Validator::make($request->all(), [
            'attorneys_name'      => 'required|string|max:255',
            'email'               => 'required|email|unique:attorneys,email',
            'phone_number'        => 'required|regex:/^[0-9+\-\(\) ]+$/',
            'specialization'      => 'nullable|string|max:255',
            'license_number'      => 'nullable|string|max:255',
            'bar_admission_date'  => 'nullable|date',
            'profile_picture' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp',
            'bio'                 => 'nullable|string',
            'gender'=>'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); // Make sure it returns a JSON response
        }


        $attroney = new AttorneysModel();
        $attroney->fill($validator->validated());

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $path = 'uploads/attorneys_images/';
            $fileName = compressImageToSize($file, $path, 100);
            $attroney['profile_picture'] = $fileName;
        }

        if ($attroney->save()) {
            return response()->json(['success' => 'Attorney Created Successfully Done']);
        } else {
            return response()->json(['error' => 'Attorney not Created Successfully Done']);
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
        $attroney=AttorneysModel::find($id);
        return view('admin_panel.attorneys.edit',compact('attroney'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Log::info($request->all());
    
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'attorneys_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'specialization' => 'required|string|max:255',
            'license_number' => 'required|string|max:255',
            'bar_admission_date' => 'nullable|date',
            'profile_picture' => 'nullable|image|max:2048', // Optional profile picture upload
            'bio' => 'required|string',
            'gender'=>'required'
        ]);
    
       
    
        // Find the attorney by ID
        $attorney = AttorneysModel::find($id);
    
        if (!$attorney) {
            return redirect()->back()->with(['error' => 'Attorney not found']);
        }
    
        // Fill the model with the validated data
        $attorney->fill($validator->validated());
    
        // Handle profile picture upload if a new file is provided
        if ($request->hasFile('profile_picture')) {
            // Delete the old profile picture if it exists
            if (Storage::disk('public')->exists('storage/uploads/attorneys_images'.$attorney->profile_picture)) {
                Storage::disk('public')->delete('storage/uploads/attorneys_images'.$attorney->profile_picture);
            }
    
            // Upload the new profile picture
            $file = $request->file('profile_picture');
            $path = 'uploads/attorneys_images/';
            $fileName = compressImageToSize($file, $path, 100);
            $attorney->profile_picture = $fileName; // Save the new image path
        }
    
        // Save the updated attorney
        if ($attorney->save()) {
            return redirect()->back()->with(['success' => 'Attorney updated successfully']);
        } else {
            return redirect()->back()->with(['error' => 'Failed to update attorney']);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attroney = AttorneysModel::find($id);
    
        if ($attroney) {
            // Check if the profile picture exists in storage
            if ($attroney->profile_picture && Storage::disk('public')->exists("uploads/attorneys_images/" . $attroney->profile_picture)) {
                // Delete the file from storage
                Storage::disk('public')->delete("uploads/attorneys_images/" . $attroney->profile_picture);
            }
    
            // Delete the attorney record from the database
            if ($attroney->delete()) {
                return response()->json(['success' => 'Attorney Deleted Successfully']);
            } else {
                return response()->json(['error' => 'Attorney Not Deleted Successfully'], 500);
            }
        } else {
            return response()->json(['error' => 'Attorney Not Found'], 404);
        }
    }
    
}
