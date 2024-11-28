<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Registration Email</title>
</head>
<body>

    @php


        use Illuminate\Support\Facades\DB;

        // Fetch user data by user ID
        $userData = DB::table('trademark_users')
            ->where('trademark_users.id', $userId) // Ensure you are using 'id' for fetching
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
            )
            ->first(); 


          
        // Fetch the email template
        $template = DB::table('email_templates')->where('slug', 'registration_email')->first();
      // Ensure the table name is correct
        $contactTemplate = $template ? $template->content : 'Email template not found.';
       
    @endphp

    @php
        // Check if $userData is not null
        if ($userData) {
            // Define the placeholder values
            $data = [
                'attorney_id' => $userData->attorney_name,
                'category_id' => $userData->category_name,
                'application_no' => $userData->application_no,
                'file_name' => $userData->file_name,
                'trademark_name' => $userData->trademark_name,
                'trademark_class' => $userData->trademark_class,
                'filling_date' => $userData->filling_date,
                'phone_no' => $userData->phone_no,
                'email_id' => $userData->email_id,
                'date_of_application' => $userData->date_of_application,
                'objected_hearing_date' => $userData->objected_hearing_date,
                'opponenet_applicant_name' => $userData->opponenet_applicant_name,
                'opposition_hearing_date' => $userData->opposition_hearing_date,
                'valid_up_to' => $userData->valid_up_to,
                'status' => $userData->status_name,
                'sub_status' => $userData->sub_status_name,
                'opp_status' => $userData->opp_status,
                'client_remarks' => $userData->client_remarks,
                'remarks' => $userData->remarks,
                'consultant_name' => $userData->consultant_name,
                'deal_with' => $userData->deal_with,
                'filed_by' => $userData->filed_by,
                'financial_year' => $userData->financial_year,
                'created_at' => $userData->created_at,
                'updated_at' => $userData->updated_at,
                'office_id' => $userData->office_name,
                'sub_category' => $userData->sub_category	
            ];
            // Replace the placeholders in the template
            foreach ($data as $key => $value) {
    $contactTemplate = str_replace("{" . $key . "}", $value, $contactTemplate);
}

        } else {
            $contactTemplate = 'User data not found.';
        }
    @endphp

    <!-- Output the processed email template -->
    {!! $contactTemplate !!}

</body>
</html>
