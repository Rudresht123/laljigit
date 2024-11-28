<?php use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\TrademarkUserModel;
use Illuminate\Support\Facades\Auth;

class ClientsImport implements ToCollection, WithChunkReading
{
    /**
     * @param Collection $rows
     * @throws ValidationException
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Validate each row
            $validator = Validator::make($row->toArray(), [
                0 => 'required|integer',  // attorney_id
                1 => 'required|integer',  // category_id
                2 => 'required|integer',  // application_no
                3 => 'required|string',   // file_name
                4 => 'required|string',   // trademark_name
                5 => 'required|integer',  // trademark_class
                6 => 'required|date',     // filling_date
                7 => 'nullable|integer',  // phone_no
                8 => 'nullable|email',    // email_id
                9 => 'required|date',     // date_of_application
                10 => 'nullable|date',    // objected_hearing_date
                11 => 'nullable|string',  // opponent_applicant_name
                12 => 'nullable|date',    // opposition_hearing_date
                13 => 'nullable|date',    // valid_up_to
                14 => 'required|integer', // status
                15 => 'nullable|integer', // opp_status
                16 => 'nullable|integer', // sub_status
                17 => 'required|integer', // client_remarks
                18 => 'required|integer', // remarks
                19 => 'nullable|string',  // consultant_name
                20 => 'nullable|string',  // deal_with
                21 => 'required|string',  // filed_by
                22 => 'required|integer', // office_id
            ]);

            if ($validator->fails()) {
                Log::error('Validation failed for row: ', $validator->errors()->toArray());
                continue;
            }

            try {
                TrademarkUserModel::create([
                    'attorney_id' => $row[0],
                    'category_id' => $row[1],
                    'application_no' => $row[2],
                    'file_name' => $row[3],
                    'trademark_name' => $row[4],
                    'trademark_class' => $row[5],
                    'filling_date' => $row[6],
                    'phone_no' => $row[7],
                    'email_id' => $row[8],
                    'date_of_application' => $row[9],
                    'objected_hearing_date' => $row[10],
                    'opponent_applicant_name' => $row[11],
                    'opposition_hearing_date' => $row[12],
                    'valid_up_to' => $row[13],
                    'status' => $row[14],
                    'opp_status' => $row[15],
                    'sub_status' => $row[16],
                    'client_remarks' => $row[17],
                    'remarks' => $row[18],
                    'consultant_name' => $row[19],
                    'deal_with' => $row[20],
                    'filed_by' => $row[21],
                    'financial_year' => Auth::user()->id,
                    'office_id' => $row[22],
                ]);

                Log::info('Data inserted successfully for row: ', $row->toArray());
            } catch (\Exception $e) {
                Log::error('Data insertion failed for row: ' . $e->getMessage(), ['data' => $row->toArray()]);
            }
        }
    }

    /**
     * Set chunk size for importing data
     */
    public function chunkSize(): int
    {
        return 1000; // Adjust this based on your server capacity
    }
}
