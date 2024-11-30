<?php

namespace App\Http\Controllers\excels;

use App\Http\Controllers\Controller;
use App\Imports\ClientsImport;
use App\Exports\ExportExcels;
use App\Models\TrademarkUserModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class ExcelsImport extends Controller
{

public function ClientsImport(Request $request){
  
        // Validate the trimmed data
        $trimmedData = $request->all();
        array_walk_recursive($trimmedData, function (&$value) {
            $value = is_string($value) ? trim($value) : $value;
        });

        $validator = Validator::make($trimmedData, [
            'category_slug' => 'required|string',
            'excel_file' => 'required|mimes:xls,xlsx',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        Log::info($request->file('excel_file'));
        Excel::import(new ClientsImport, $request->file('excel_file'));
}
    public function ClientsExcelExport(Request $request){
        $query = TrademarkUserModel::query()
        ->join('attorneys', 'trademark_users.attorney_id', '=', 'attorneys.id')
        ->join('main_category', 'trademark_users.category_id', '=', 'main_category.id')
        ->join('offices', 'trademark_users.office_id', '=', 'offices.id')
        ->join('status', 'trademark_users.status', '=', 'status.id')
        ->join('sub_status', 'trademark_users.sub_status', '=', 'sub_status.id')
        ->join('client_remarks', 'trademark_users.client_remarks', '=', 'client_remarks.id')
        ->join('remarks', 'trademark_users.remarks', '=', 'remarks.id')
        ->join('opposition_status', 'trademark_users.opp_status', '=', 'opposition_status.id')
        ->select(
            'trademark_users.*',  
            'attorneys.attorneys_name as attorney_name',  
            'main_category.category_name as category_name',  
            'offices.office_name as office_name',  
            'status.status_name as status_name',  
            'sub_status.substatus_name as sub_status_name',  
            'client_remarks.client_remarks as client_remark',  
            'remarks.remarks as remark',  
            'opposition_status.opp_status_name as opposition_status_name'
        );

    // Apply filters like in your form
    if (!empty($request->attorney_id)) {
        $query->whereIn('trademark_users.attorney_id', (array)$request->attorney_id);
    }

    if (!empty($request->maincategory)) {
        $query->whereIn('trademark_users.category_id', (array)$request->maincategory);
    }

    if (!empty($request->status)) {
        $query->whereIn('trademark_users.status', (array)$request->status);
    }

    if (!empty($request->start) && !empty($request->from)) {
        $query->whereBetween('trademark_users.created_at', [$request->start, $request->from]);
    }

    // Export the filtered data
    return Excel::download(new ExportExcels($query), 'filtered_data.xlsx');
}
}

