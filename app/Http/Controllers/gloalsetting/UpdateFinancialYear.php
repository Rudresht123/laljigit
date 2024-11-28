<?php

namespace App\Http\Controllers\gloalsetting;

use App\Http\Controllers\Controller;
use App\Models\FinancialYearModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class UpdateFinancialYear extends Controller
{
public function updateSession(Request $request)
{
    // Validate request
    $data = Validator::make($request->all(), [
        'financial_id' => 'required|exists:financial_year,id'
    ]);

    
    if ($data->fails()) {
        return response()->json([
            'error' => $data->errors()
        ], 422);
    }

    // Retrieve current session ID
    $currentSessionId = Session::get('id');

    // Find the current session and deactivate it
    $currentSession = FinancialYearModel::findOrFail($currentSessionId);
    $currentSession->is_active = 'no';
    $currentSession->save();

   
    // Find the new session and activate it
    $newSession = FinancialYearModel::findOrFail($request->financial_id); // Use the validated financial_year
    $newSession->is_active = 'yes';
    $newSession->save();

    // Set the new active academic session in the session
    setActiveFinancialSession();

    return response()->json(['success' => 'Session updated successfully']);
}    }
