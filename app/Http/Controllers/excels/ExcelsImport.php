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
        
          $query=TrademarkUserModel::with(
            'attorney:id,attorneys_name',
            'mainCategory:id,category_name,category_slug',
            'office:id,office_name',
            'statusMain:id,status_name',
            'subStatus:id,substatus_name',
            'clientRemark:id,client_remarks',
            'remarksMain:id,remarks as remarks_name',
            'Clientonsultant:id,consultant_name',
            'dealWith:id,dealler_name',
            'subCategory:id,subcategory',
            'financialYear:id,financial_session'
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

    $columns = $request->input('column');
    return Excel::download(new ExportExcels($query,$columns), 'trademark_clients.xlsx');
}
}

