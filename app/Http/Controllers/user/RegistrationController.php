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
use App\Models\StatusHistory;

class RegistrationController extends Controller
{
    public function showAttorneyCatgory($id)
    {
        $attorney =AttorneysModel::find($id);
        $mainCategory = MainCategoryModel::where('status','yes')->get();


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

    // Rgistration code for trademarkk users
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
            // dynamic fileds rules 
            'applicant_name'=>'nullable|string',
            'applicant_code'=>'nullable|string',
            'opponent_name'=>'nullable|string',
            'opponent_code'=>'nullable|string',
            'opponent_applicant' => 'nullable|string',
            'hearing_date'=>'nullable|date',
            'examination_report_submitted'=>'nullable|string',
            'opposed_no'=>'nullable|string',
            'rectification_no'=>'nullable|string',
            // dynamic fileds rules 
            'opposition_hearing_date' => 'nullable|date',
            'status' => 'required',
            'consultant' => 'required|string',
            'deal_with' => 'nullable|string',
            'filed_by' => 'nullable',
            'client_remarks' => 'required',
            'remarks' => 'required',
            'sub_status' => 'required',
            'office_id' => 'required',
            'sub_category' => 'required',
            'ip_field'=>'required|string',
            'email_remarks'=>'nullable|string',
            'evidence_last_date'=>'nullable|date',
            'client_communication'=>'nullable|string',
            'mail_recived_date'=>'nullable|date',
            'mail_recived_date_2'=>'nullable|date',
            'valid_up_to'=>'nullable|date'		
        ]);

        $application_no=$request->input('application_no');
        $TrademarkUser = new TrademarkUserModel();
        $TrademarkUser->fill($request->all());
        $clientEmail=$request->email_id;
        $TrademarkUser['financial_year'] = Session::get('id');

    // dynamic fields code here
    if ($request->filled('opponent_applicant')) {
        $TrademarkUser['opponent_applicant'] = $request->input('opponent_applicant');
        if ($TrademarkUser['opponent_applicant'] === 'Applicant') {
            $TrademarkUser['opponenet_applicant_name'] = $request->input('opponent_name');
            $TrademarkUser['opponent_applicant_code'] = $request->input('opponent_code');
        } elseif ($TrademarkUser['opponent_applicant'] === 'Opponent') {
            $TrademarkUser['opponenet_applicant_name'] = $request->input('applicant_name');
            $TrademarkUser['opponent_applicant_code'] = $request->input('applicant_code');
        }
    }
    
    // dynamic fileds code end here
        if ($TrademarkUser->save()) {
            echo $TrademarkUser->id;

            StatusHistory::create([
                'client_id' => $TrademarkUser->id,
                'file_name'=>$request->input('file_name'), 
                'status_history' => json_encode([
                    [
                        'status' => $request->input('status'),
                        'sub_status' => $request->input('sub_status'),
                        'date' => now()->toDateTimeString(),
                    ]
                ]),
            ]);
            return redirect()->back()->with(['success' => 'User Registered Successfully Done']);
        }
    else{
        return redirect()->back()->with(['error' => 'User not Registerd Successfully Done']);
    }
        }
        
    

    public function clientsDetails($category_slug, $id)
    {
       
    if ($category_slug === 'trademark') {
    $clientdetail = TrademarkUserModel::with([
    'attorney:id,attorneys_name',
    'mainCategory:id,category_name,category_slug',
    'office:id,office_name',
    'statusMain:id,status_name',
    'subStatus:id,substatus_name',
    'remarksMain:id,remarks as remarks_name',
    'clientRemark:id,client_remarks',
    'Clientonsultant:id,consultant_name',
    'dealWith:id,dealler_name',
    'financialYear:id,financial_session',
    'subCategory:id,subcategory'
])
->where('id', $id)
->first();
            return view('admin_panel.users.clientdetails', compact('clientdetail'));
        }
    }

    public function editClientDetails($attorneyId, $categorySlug, $id)
    {
        $attorney = AttorneysModel::find($attorneyId);

        $client = TrademarkUserModel::where('id', $id)->first();
        $category = MainCategoryModel::where('category_slug', $categorySlug)->first();
        $classes = TradeMarkClassModel::get();
        $offices = OfficesModel::where('status', 'yes')->get();
        $remarks = RemarksModel::where('is_active', 'yes')->get();
        $clientRemarks = ClientRemarksModel::where('status', 'yes')->get();
        $consultant = ConsultantModel::where('status', 'yes')->get();
        $dealWith = DeallerModel::where('status', 'yes')->get();

        $statuss = StatusModel::where('status', 'yes')->get();
        $subcategory = SubcategoryModel::get();


        return view('admin_panel.users.editClientdetails', compact('client', 'attorney', 'category', 'classes', 'statuss', 'remarks', 'offices', 'clientRemarks', 'consultant', 'subcategory','dealWith'));
    }

    public function updateClientDetails($id, Request $request)
    {
       
        $request->validate([
            'attorney_id' => 'required',
            'category_id' => 'required',
            'application_no' => 'required',
            'file_name' => 'required|string',
            'trademark_name' => 'required|string',
            'trademark_class' => 'required',
            'filling_date' => 'required|date',
            'phone_no' => 'required',
            'email_id' => 'required|email',
            'date_of_application' => 'nullable|date',
            'objected_hearing_date' => 'nullable|date',
            'applicant_name' => 'nullable|string',
            'applicant_code' => 'nullable|string',
            'opponent_name' => 'nullable|string',
            'opponent_code' => 'nullable|string',
            'opponent_applicant' => 'nullable|string',
            'hearing_date' => 'nullable|date',
            'examination_report' => 'nullable|string',
            'opposed_no' => 'nullable|string',
            'rectification_no' => 'nullable|string',
            'opposition_hearing_date' => 'nullable|date',
            'status' => 'required',
            'consultant' => 'required|string',
            'deal_with' => 'nullable|string',
            'filed_by' => 'nullable',
            'client_remarks' => 'required',
            'remarks' => 'required',
            'sub_status' => 'required',
            'office_id' => 'required',
            'sub_category' => 'required',
            'ip_field' => 'required|string',
            'email_remarks' => 'nullable|string',
            'evidence_last_date' => 'nullable|date',
            'client_communication' => 'nullable|string',
            'mail_recived_date' => 'nullable|date',
            'mail_recived_date_2' => 'nullable|date',
            'valid_up_to' => 'nullable|date',
        ]);
    
        // Retrieve the record
        $TrademarkUser = TrademarkUserModel::where('id', $id)->first();
        if (!$TrademarkUser) {
            return redirect()->back()->with(['error' => 'User not found']);
        }
    
        $TrademarkUser->fill($request->all());
        $status = $request->input('status');
        handleStatusLogic($TrademarkUser, $status, $request);
    
        // Set financial year from session
        $financialYearId = Session::get('id', null);
        if (!$financialYearId) {
            return redirect()->back()->with(['error' => 'Financial year session is not set.']);
        }
        $TrademarkUser->financial_year = $financialYearId;
    
        // Update and handle response
        if ($TrademarkUser->update()) {
           updateStatusHistory([
    'id' => $id,
    'status' => $request->input('status'),
    'sub_status' => $request->input('sub_status'),
    'file_name' => $request->input('file_name')
]);
            return redirect()->back()->with(['success' => 'User updated successfully']);
        } else {
            \Log::error('Failed to update TrademarkUser', ['data' => $TrademarkUser->toArray()]);
            return redirect()->back()->with(['error' => 'User update failed']);
        }
    }
    
    
    /**
     * Handle status-specific logic
     */
   
    
    /**
     * Update status history for the application
     */
  

/**
 * Handle the opponent applicant data dynamically
 */




}
