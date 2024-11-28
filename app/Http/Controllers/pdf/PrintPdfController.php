<?php

namespace App\Http\Controllers\pdf;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrintPdfController extends Controller
{
    public function printClientPdf($category_slug, $application_no)
    {


        if($category_slug==='trademark'){
        $userData = DB::table('trademark_users')
            ->where('trademark_users.application_no', $application_no) // Ensure you are using 'id' for fetching
            ->join('attorneys', 'trademark_users.attorney_id', '=', 'attorneys.id')
            ->join('main_category', 'trademark_users.category_id', '=', 'main_category.id')
            ->join('offices', 'trademark_users.office_id', '=', 'offices.id')
            ->join('status', 'trademark_users.status', '=', 'status.id')
            ->join('sub_status', 'trademark_users.sub_status', '=', 'sub_status.id')
            ->join('client_remarks', 'trademark_users.client_remarks', '=', 'client_remarks.id')
            ->join('remarks', 'trademark_users.remarks', '=', 'remarks.id')
            ->join('financial_year', 'trademark_users.financial_year', '=', 'financial_year.id')
            ->join('consultant', 'trademark_users.consultant', '=', 'consultant.id')
            ->join('sub_category', 'trademark_users.sub_category', '=', 'sub_category.id')
            ->select(
                'trademark_users.*',
                'attorneys.attorneys_name as attorney_name',
                'main_category.category_name as category_name',
                'offices.office_name as office_name',
                'status.status_name as status_name',
                'sub_status.substatus_name as sub_status_name',
                'client_remarks.client_remarks as client_remark',
                'remarks.remarks as remark',
                'sub_category.subcategory as subcategory',
                'financial_year.financial_session as financial_session',
                'consultant.consultant_name as consultant_name'
            )
            ->first();


       


        // Fetch the email template
        $template = DB::table('pdf_templates')->where('template_slug', 'client_detail_pdf')->first();
        // Ensure the table name is correct
        $contactTemplate = $template ? $template->content : 'PDF template not found.';
        $title=$template->template_no ?? 'Client Details PDF';

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
                'client_remarks' => $userData->client_remark,
                'remarks' => $userData->remark,
                'consultant_name' => $userData->consultant_name,
                'deal_with' => $userData->deal_with,
                'filed_by' => $userData->filed_by,
                'financial_year' => $userData->financial_session,
                'created_at' => $userData->created_at,
                'updated_at' => $userData->updated_at,
                'office_id' => $userData->office_name,
                'sub_category' => $userData->subcategory
            ];
            // Replace the placeholders in the template
            foreach ($data as $key => $value) {
                $contactTemplate = str_replace("{" . $key . "}", $value, $contactTemplate);
            }

            $contactTemplate = str_replace(
                "{" . 'template_logo' . "}",
                asset('storage/uploads/pdf_logos/' . $template->template_logo),
                $contactTemplate
            );
                } else {
            $contactTemplate = 'User data not found.';
        }
        return view('admin_panel.pdfs_setting.printpdf',compact('contactTemplate','title'));
    }
        
    }
}
