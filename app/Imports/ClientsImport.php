<?php

namespace App\Imports;

use App\Models\StatusHistory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\TrademarkUserModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ClientsImport implements ToModel, WithHeadingRow, WithChunkReading
{
    /**
     * Define chunk size to process 1000 rows at a time
     */
    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * Map the rows from the Excel file to the TrademarkUserModel fields
     */
    public function model(array $row)
    {
        $validator = Validator::make($row, [
            'attorney_id' => 'required',
            'category_id' => 'required',
            'application_no' => 'required',
            'file_name' => 'required|string',
            'trademark_name' => 'required|string',
            'trademark_class' => 'required',
            'filling_date' => 'required|date',
            'phone_no' => 'nullable',
            'email_id' => 'nullable',
            'objected_hearing_date' => 'nullable|date',
            'opposition_no' => 'nullable|string',
            'opponenet_applicant_name' => 'nullable|string',
            'opponent_applicant_code' => 'nullable|string',
            'opponent_applicant' => 'nullable|string',
            'hearing_date' => 'nullable|date',
            'examination_report' => 'nullable|string',
            'opposed_no' => 'nullable|string',
            'rectification_no' => 'nullable|string',
            'opposition_hearing_date' => 'nullable|date',
            'status' => 'required',
            'consultant' => 'nullable',
            'deal_with' => 'nullable',
            'filed_by' => 'nullable',
            'client_remarks' => 'nullable',
            'remarks' => 'nullable',
            'sub_status' => 'nullable',
            'office_id' => 'nullable',
            'sub_category' => 'nullable',
            'ip_field' => 'nullable|string',
            'email_remarks' => 'nullable|string',
            'evidence_last_date' => 'nullable|date',
            'client_communication' => 'nullable|string',
            'mail_recived_date' => 'nullable|date',
            'mail_recived_date_2' => 'nullable|date',
            'valid_up_to' => 'nullable|date',
        ]);
    
        if ($validator->fails()) {
            Log::error('Validation errors in row: ' . json_encode($row) . ' Errors: ' . json_encode($validator->errors()));
            return null; // Skip this row
        }
    
        // Check if application_no already exists
        if (TrademarkUserModel::where('application_no', $row['application_no'])->exists()) {
            Log::info("Skipping row with duplicate application_no: " . $row['application_no']);
            return null; // Skip this row
        }
    
        // Ensure deal_with is a string
       
    
        // Create new trademark user
        $trademarkUser = new TrademarkUserModel([
            'attorney_id' => $row['attorney_id'],
            'category_id' => $row['category_id'],
            'application_no' => $row['application_no'],
            'file_name' => $row['file_name'],
            'trademark_name' => $row['trademark_name'],
            'trademark_class' => $row['trademark_class'],
            'filling_date' => $row['filling_date'],
            'phone_no' => $row['phone_no'],
            'email_id' => $row['email_id'],
            'objected_hearing_date' => $row['objected_hearing_date'],
            'opponenet_applicant_name' => $row['opponenet_applicant_name'],
            'opponent_applicant_code' => $row['opponent_applicant_code'],
            'opponent_applicant' => $row['opponent_applicant'],
            'hearing_date' => $row['hearing_date'],
            'examination_report' => $row['examination_report'],
            'opposed_no' => $row['opposed_no'],
            'rectification_no' => $row['rectification_no'],
            'opposition_hearing_date' => $row['opposition_hearing_date'],
            'status' => $row['status'],
            'consultant' => $row['consultant'],
            $row['deal_with'] = (string) ($row['deal_with'] ?? ''),
            'filed_by' => $row['filed_by'],
            'client_remarks' => $row['client_remarks'],
            'remarks' => $row['remarks'],
            'sub_status' => $row['sub_status'],
            'office_id' => $row['office_id'],
            'sub_category' => $row['sub_category'],
            'ip_field' => $row['ip_field'],
            'email_remarks' => $row['email_remarks'],
            'evidence_last_date' => $row['evidence_last_date'],
            'client_communication' => $row['client_communication'],
            'mail_recived_date' => $row['mail_recived_date'],
            'mail_recived_date_2' => $row['mail_recived_date_2'],
            'valid_up_to' => $row['valid_up_to'],
            'financial_year' => $row['financial_year'],
        ]);
        $trademarkUser->save();
    
        // Save status history
        StatusHistory::create([
            'application_no' => $row['application_no'],
            'file_name' => $row['file_name'],
            'status_history' => json_encode([
                [
                    'status' => $row['status'],
                    'sub_status' => $row['sub_status'],
                    'date' => now()->toDateTimeString(),
                ],
            ]),
        ]);
    }
    
}

