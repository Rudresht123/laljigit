<?php

namespace App\Http\Controllers\pdf;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TrademarkUserModel;

class PrintPdfController extends Controller
{
    public function printClientPdf($category_slug, $application_no)
    {


        if($category_slug==='trademark'){
            
            $userData=TrademarkUserModel::with(
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
            )->where('application_no',$application_no)->first();
                

        // Fetch the email template
        $template = DB::table('pdf_templates')->where('template_slug', 'client_detail_pdf')->first();
        // Ensure the table name is correct
        $contactTemplate = $template ? $template->content : 'PDF template not found.';
        $title=$template->template_no ?? 'Client Details PDF';

        // Check if $userData is not null
        if ($userData) {
            // Define the placeholder values
            $data = [
                'attorney_id' => $userData->attorney_name ?? '',
                'category_id' => $userData->mainCategory->category_name ?? '',
                'application_no' => $userData->application_no ?? '',
                'file_name' => $userData->file_name ?? '',
                'trademark_name' => $userData->trademark_name ?? '',
                'trademark_class' => $userData->trademark_class ?? '',
                'filling_date' => $userData->filling_date ?? '',
                'phone_no' => $userData->phone_no ?? '',
                'email_id' => $userData->email_id ?? '',
                'date_of_application' => $userData->date_of_application ?? '',
                'objected_hearing_date' => $userData->objected_hearing_date ?? '',
                'opponenet_applicant_name' => $userData->opponenet_applicant_name ?? '',
                'opposition_hearing_date' => $userData->opposition_hearing_date ?? '',
                'valid_up_to' => $userData->valid_up_to ?? '',
                'status' => $userData->statusMain->status_name ?? '',
                'sub_status' => $userData->subStatus->sub_status_name ?? '',
                'client_remarks' => $userData->clientRemark->client_remark ?? '',
                'remarks' => $userData->remarksMain->remarks_name ?? '',
                'consultant_name' => $userData->Clientonsultant->consultant_name ?? '',
                'deal_with' => $userData->dealWith->dealler_name ?? '',
                'filed_by' => $userData->filed_by ?? '',
                'financial_year' => $userData->financialYear->financial_session ?? '',
                'created_at' => $userData->created_at ?? '',
                'updated_at' => $userData->updated_at ?? '',
                'office_id' => $userData->office->office_name ?? '',
                'sub_category' => $userData->subCategory->subcategory ?? '',
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
