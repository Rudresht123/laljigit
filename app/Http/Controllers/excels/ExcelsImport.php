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

    public function ClientsImport(Request $request)
    {
    

        // Trim all request input data
        $trimmedData = $request->all();
        array_walk_recursive($trimmedData, function (&$value) {
            $value = is_string($value) ? trim($value) : $value;
        });

        // Validate the trimmed data
        $validator = Validator::make($trimmedData, [
            'category_slug' => 'required|string',
            'excel_file' => 'required|mimes:xls,xlsx',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        if ($trimmedData['category_slug'] === 'trademark') {
            try {
                // Read the Excel file directly and process it
                $rows = Excel::toCollection(null, $request->file('excel_file'));

                // Iterate over each row
                foreach ($rows[0] as $row) {
                    // Trim each value
                    $trimmedRow = $row->map(function ($value) {
                        return is_string($value) ? trim($value) : $value;
                    });

                    // Check if application_no already exists
                    if (TrademarkUserModel::where('application_no', $trimmedRow[2])->exists()) {
                        // Skip this row if application_no exists
                        Log::info('Skipping existing application_no: ' . $trimmedRow[2]);
                        continue;
                    }

                    // Create a new Client record in the database
                    TrademarkUserModel::create([
                        'attorney_id' => $trimmedRow[0],
                        'category_id' => $trimmedRow[1],
                        'application_no' => $trimmedRow[2],
                        'file_name' => $trimmedRow[3],
                        'trademark_name' => $trimmedRow[4],
                        'trademark_class' => $trimmedRow[5],
                        'filling_date' => formatDate($trimmedRow[6], 'Y-m-d'),
                        'phone_no' => $trimmedRow[7], // Clean phone number
                        'email_id' => $trimmedRow[8],
                        'date_of_application' => formatDate($trimmedRow[9], 'Y-m-d'),
                        'objected_hearing_date' => formatDate($trimmedRow[10], 'Y-m-d'),
                        'opponenet_applicant_name' => $trimmedRow[11],
                        'opposition_hearing_date' => formatDate($trimmedRow[12], 'Y-m-d'),
                        'valid_up_to' => formatDate($trimmedRow[13], 'Y-m-d'),
                        'status' => $trimmedRow[14],
                        'opp_status' => $trimmedRow[15],
                        'sub_status' => $trimmedRow[16],
                        'client_remarks' => $trimmedRow[17],
                        'remarks' => $trimmedRow[18],
                        'consultant_name' => $trimmedRow[19],
                        'deal_with' => $trimmedRow[20],
                        'filed_by' => $trimmedRow[21],
                        'office_id' => $trimmedRow[22],
                        'sub_category'=>$trimmedRow[23],
                        'financial_year' => Auth::user()->id,
                    ]);
                }

                return response()->json(['success' => 'Clients Imported Successfully']);
            } catch (ValidationException $e) {
                // Handle validation errors
                Log::error('Validation errors during import: ', $e->validator->errors()->toArray());
                return response()->json(['errors' => $e->validator->errors()], 422);
            } catch (\Exception $e) {
                // Catch any other exception during import
                Log::error('Import failed: ' . $e->getMessage());
                return response()->json(['error' => 'Import Failed: ' . $e->getMessage()], 500);
            }
        } else {
            return response()->json(['error' => 'Invalid category ID'], 400);
        }
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

