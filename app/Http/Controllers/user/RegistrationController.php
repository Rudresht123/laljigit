<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Mail\RegistrationMail;
use Illuminate\Support\Facades\Session;
use App\Models\AttorneysModel;
use App\Models\ClientRemarksModel;
use App\Models\FormFieldModel;
use App\Models\MainCategoryModel;
use App\Models\OfficesModel;
use App\Models\ConsultantModel;
use App\Models\RemarksModel;
use App\Models\StatusModel;
use App\Models\SubcategoryModel;
use App\Models\TradeMarkClassModel;
use App\Models\TrademarkUserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\DeallerModel;

class RegistrationController extends Controller
{
    public function showAttorneyCatgory($id)
    {
        $attorney =AttorneysModel::find($id);
        $mainCategory = MainCategoryModel::get();


        //Status wise count chart 
        $statuswisecount = StatusModel::withCount([
            'trademarkUsers as usercount' => function ($query) use ($id) {
                $query->where('attorney_id', $id);
            }
        ])->get();


        $totalCount=TrademarkUserModel::where('attorney_id',$id)->count();
        return view('admin_panel.users.category', compact('attorney', 'mainCategory','statuswisecount','totalCount'));
    }
    public function registrationForm($attorneyId, $categorySlug)
    {
        $attorney = AttorneysModel::find($attorneyId);


        $category = MainCategoryModel::where('category_slug', $categorySlug)->first();
        $classes = TradeMarkClassModel::get();
        $offices = OfficesModel::where('status', 'yes')->get();
        $remarks = RemarksModel::where('is_active', 'yes')->get();
        $clientRemarks = ClientRemarksModel::where('status', 'yes')->get();
        $consultant = ConsultantModel::where('status', 'yes')->get();
        $dealWith = DeallerModel::where('status', 'yes')->get();

     
        $statuss = StatusModel::where('status', 'yes')->get();
        $subcategory = SubcategoryModel::get();
        return view('admin_panel.users.registrationform', compact('attorney', 'category', 'classes', 'statuss', 'remarks', 'offices', 'clientRemarks', 'consultant', 'subcategory','dealWith'));
    }
    public function addTrademarkUserForm(Request $request)
    {

        $request->validate([
            'attorney_id' => 'required',
            'category_id' => 'required',
            'application_no' => 'required',
            'file_name' => 'required|string',
            'trademark_name' => 'required|string',
            'trademark_class' => 'required',
            'filling_date' => 'required|date',
            'phone_no' => 'required|digits:10',
            'email_id' => 'required|email',
            'date_of_application' => 'nullable|date',
            'objected_hearing_date' => 'nullable|date',
            'opponenet_applicant_name' => 'nullable|string',
            'opposition_hearing_date' => 'nullable|date',
            'status' => 'required',
            'consultant_name' => 'nullable|string',
            'deal_with' => 'nullable|string',
            'filed_by' => 'nullable',
            'client_remarks' => 'required',
            'opp_status' => 'required',
            'remarks' => 'required',
            'sub_status' => 'required',
            'office_id' => 'required',
            'sub_category' => 'required',
            'ip_field'=>'required|string',
            'email_remarks'=>'nullable|string',
            'evidence_last_date'=>'nullable|date',
            'client_communication'=>'nullable|string',
            'mail_recived_date'=>'nullable|date',
            'mail_recived_date_2'=>'nullable|date'	
        ]);
        $TrademarkUser = new TrademarkUserModel();
        $TrademarkUser->fill($request->all());
        $clientEmail=$request->email_id;
        $TrademarkUser['financial_year'] = Session::get('id');
        $userdata = $TrademarkUser->save();
        $userId = $TrademarkUser->id;
        if ($userdata) {
            if ($userdata){
             return redirect()->back()->with(['success' => 'User Registered Successfully Done']);
            } else {
                return redirect()->back()->with(['error' => 'User not Registerd Successfully Done']);
            }
        }
        }
    

    public function clientsDetails($category_slug, $application_no)
    {
        if ($category_slug === 'trademark') {
            $clientdetail = TrademarkUserModel::query()
                ->join('attorneys', 'trademark_users.attorney_id', '=', 'attorneys.id')
                ->join('main_category', 'trademark_users.category_id', '=', 'main_category.id')
                ->join('offices', 'trademark_users.office_id', '=', 'offices.id')
                ->join('status', 'trademark_users.status', '=', 'status.id')
                ->join('sub_status', 'trademark_users.sub_status', '=', 'sub_status.id')
                ->join('client_remarks', 'trademark_users.client_remarks', '=', 'client_remarks.id')
                ->join('remarks', 'trademark_users.remarks', '=', 'remarks.id')
                ->join('consultant', 'trademark_users.consultant', '=', 'consultant.id')
                ->join('financial_year', 'trademark_users.financial_year', '=', 'financial_year.id')
                ->join('sub_category', 'trademark_users.sub_category', '=', 'sub_category.id')
                ->select(
                    'trademark_users.*',
                    'attorneys.attorneys_name as attorney_name',
                    'main_category.category_name as category_name',
                    'main_category.category_slug as category_slug',
                    'offices.office_name as office_name',
                    'status.status_name as status_name',
                    'sub_status.substatus_name as sub_status_name',
                    'sub_category.subcategory as subcategory_name',
                    'client_remarks.client_remarks as client_remark_name',
                    'remarks.remarks as remark',
                    'consultant.consultant_name as consultant_name',
                    'financial_year.financial_session as financial_session'
                )
                ->where('trademark_users.application_no', $application_no)
                ->first();



            // Initialize a flag to check if any filters were applied
            return view('admin_panel.users.clientdetails', compact('clientdetail'));
        }
    }

    public function editClientDetails($attorneyId, $categorySlug, $application_no)
    {
        $attorney = AttorneysModel::find($attorneyId);

        $client = TrademarkUserModel::where('application_no', $application_no)->first();
        $category = MainCategoryModel::where('category_slug', $categorySlug)->first();
        $classes = TradeMarkClassModel::get();
        $offices = OfficesModel::where('status', 'yes')->get();
        $remarks = RemarksModel::where('is_active', 'yes')->get();
        $clientRemarks = ClientRemarksModel::where('status', 'yes')->get();
        $consultant = ConsultantModel::where('status', 'yes')->get();

        $statuss = StatusModel::where('status', 'yes')->get();
        $subcategory = SubcategoryModel::get();


        return view('admin_panel.users.editClientdetails', compact('client', 'attorney', 'category', 'classes', 'statuss', 'remarks', 'offices', 'clientRemarks', 'consultant', 'subcategory'));
    }
    public function updateClientDetails($ApplicationNo, Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'attorney_id' => 'required',
            'category_id' => 'required',
            'application_no' => 'required',
            'file_name' => 'required|string',
            'trademark_name' => 'required|string',
            'trademark_class' => 'required',
            'filling_date' => 'required|date',
            'phone_no' => 'required|digits:10',
            'email_id' => 'required|email',
            'date_of_application' => 'nullable|date',
            'objected_hearing_date' => 'nullable|date',
            'opponenet_applicant_name' => 'nullable|string',
            'opposition_hearing_date' => 'nullable|date',
            'status' => 'required',
            'consultant_name' => 'nullable|string',
            'deal_with' => 'nullable|string',
            'filed_by' => 'nullable',
            'client_remarks' => 'required',
            'opp_status' => 'required',
            'remarks' => 'required',
            'sub_status' => 'required',
            'office_id' => 'required',
            'sub_category' => 'required',
            'ip_field'=>'required|string',
            'email_remarks'=>'nullable|string',
            'evidence_last_date'=>'nullable|date',
            'client_communication'=>'nullable|string',
            'mail_recived_date'=>'nullable|date',
            'mail_recived_date_2'=>'nullable|date'	
        ]);

        // Find the TrademarkUser by application number
        $TrademarkUser = TrademarkUserModel::where('application_no', $ApplicationNo)->first();

        // Check if the record exists
        if (!$TrademarkUser) {
            return redirect()->back()->with(['error' => 'User not found']);
        }

        // Fill the model with request data
        $TrademarkUser->fill($request->all());

        // Assign the financial year from the session
        $TrademarkUser->financial_year = Session::get('id');

        // Save the changes to the database
        if ($TrademarkUser->save()) {
            return redirect()->back()->with(['success' => 'User updated successfully']);
        } else {
            return redirect()->back()->with(['error' => 'User update failed']);
        }
    }
}
