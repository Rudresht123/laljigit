<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubcategoryModel;
use App\Models\SubStatusModel;
use App\Models\TrademarkUserModel;
use App\Models\AttorneysModel;
use App\Models\StatusHistory;
use App\Models\StatusModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class CustomFunctions extends Controller
{
    public function getSubStatus($id)
    {
        $data = SubStatusModel::where('main_status_id', $id)->where('status', 'yes')->get();
        if ($data) {
            return response()->json($data);
        }
    }
      public function getClients(Request $request)
    {
        // Define the query with the required relationships
       $query = TrademarkUserModel::with([
            'attorney:id,attorneys_name',
            'mainCategory:id,category_name,category_slug',
            'office:id,office_name',
            'statusMain:id,status_name',
            'subStatus:id,substatus_name',
            'clientRemark:id,client_remarks',
            'remarksMain:id,remarks as remarks_name',
            'dealWith:id,dealler_name',
            'Clientonsultant:id,consultant_name',
            'financialYear:id,financial_session'
        ]);
    
        // Apply filters
        if ($request->filled('attorney_id')) {
            $query->whereIn('attorney_id', $request->attorney_id);
        }
    
        if ($request->filled('maincategory')) {
            $query->whereIn('category_id', $request->maincategory);
        }
    
        if ($request->filled('status')) {
            $query->whereIn('status', $request->status);
        }
    
        if ($request->filled('start_date') && $request->filled('end')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end]);
        }
    
        if ($request->filled('id_range_start') && $request->filled('id_range_end')) {
            $query->whereBetween('id', [$request->id_range_start, $request->id_range_end]);
        }
    
        // Search functionality
        if ($request->filled('search.value')) {
            $searchValue = trim($request->input('search.value'));
            $query->where(function ($q) use ($searchValue) {
                $q->
                    where('application_no', 'like', '%' . intval($searchValue) . '%')
                    ->orWhere('trademark_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('file_name', 'like', '%' . $searchValue . '%');
            });
        }

        // Apply ordering
        if ($request->has('order')) {
            $order = $request->input('order')[0];
            $columnIndex = $order['column'];
            $sortDirection = $order['dir'];
            $columns = $request->input('columns');
    
            if (isset($columns[$columnIndex])) {
                $columnName = $columns[$columnIndex]['name'];
                $query->orderBy($columnName, $sortDirection);
            }
        } else {
            $query->orderBy('id', 'asc');
        }
    
        // Pagination parameters
        $length = $request->input('length', 10);
        $start = $request->input('start', 0);
    
     
        // Get the filtered records count before applying pagination
        $filteredRecords = $query->count();
    
        // Apply pagination
        $data = $query->skip($start)->take($length)->get();
    
        // Total records in the database
        $totalRecords = TrademarkUserModel::count();
    
     // <button class="dropdown-item editStatus" data-id="' . $item->id . '" data-category-id="' . $item->mainCategory->id . '" data-category-slug="' . $item->mainCategory->category_slug . '">
                                    //     <i class="typcn typcn-edit"></i> Edit Status
                                    // </button>
                                    
                                    
        // Format the data

        $tableColumns=Schema::getColumnListing('trademark_users');
$formattedData = $data->transform(function ($item, $index) use ($start,$tableColumns) {
    $rowData = ['DT_RowIndex' => $start + $index + 1]; // Add index
    
    foreach ($tableColumns as $tableColumn) {
        if($tableColumn=='application_no'){
            $rowData[$tableColumn] = '<a href="' . route('admin.attorney.clientDetails', [
                'category_slug' => $item->mainCategory->category_slug,
                'id' => $item->id
            ]) . '">' .$item->$tableColumn . '</a>';
        }else{
            $rowData[$tableColumn] = $item->$tableColumn;
        }
    }
      $rowData['attorney_id'] = $item->attorney->attorneys_name ?? '';
    $rowData['status'] = $item->statusMain->status_name ?? '';
    $rowData['deal_with'] = $item->dealWith->dealler_name ?? 'NA';
    $rowData['category_id'] = $item->mainCategory->category_name ?? '';
    $rowData['financial_year'] = $item->financialYear->financial_session ?? '';
    $rowData['office_id'] = $item->office->office_name ?? '';
    $rowData['sub_status'] = $item->subStatus->substatus_name?? '';
    $rowData['consultant'] = $item->Clientonsultant->consultant_name?? 'NA';
    $rowData['client_remarks'] = $item->clientRemark->client_remarks?? 'NA';
    $rowData['remarks'] = $item->remarksMain->remarks_name ?? '';
  
    // Add actions (static content)
    $rowData['actions'] = '<div class="dropdown dropstart">
                                <button class="btn btn-secondary p-1 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="typcn typcn-th-small"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a target="_blank" class="dropdown-item" href="' . route('admin.client-details.print-pdf', [
                                        'category_slug' => $item->mainCategory->category_slug,
                                        'id' => $item->id
                                    ]) . '">
                                        <i class="typcn typcn-document-add"></i> PDF Print
                                    </a>
                                    <a target="_blank" class="dropdown-item" href="' . route('admin.attorney.edit-clientDetails', [
                                        'attoerny_id' => $item->attorney_id,
                                        'category_slug' => $item->mainCategory->category_slug,
                                        'id' => $item->id
                                    ]) . '">
                                        <i class="typcn typcn-edit"></i> Update Status
                                    </a>
                                    <a target="_blank" class="dropdown-item" href="' . route('admin.status.client-status', [
                                        'id' => $item->id
                                    ]) . '">
                                        <i class="typcn typcn-document-add"></i> Status Details
                                    </a>
                                    <a class="dropdown-item" href="' . route('admin.attorney.clientDetails', [
                                        'category_slug' => $item->mainCategory->category_slug,
                                        'id' => $item->id
                                    ]) . '">
                                        <i class="typcn typcn-edit"></i> Client Details
                                    </a>
                                </div>
                            </div>';

    // Return the formatted row data
    return $rowData;
});
        // Return JSON response for DataTables
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,        // Total records in DB
            'recordsFiltered' => $filteredRecords, // Records after filtering
            'data' => $formattedData,              // Current page's data
        ]);
    }
    public function getClientDetailsForUpdateStatus(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'clientId' => 'required|integer',
            'categoryId' => 'required|integer',
            'categorySlug' => 'required|string'
        ]);
    
        // Return validation errors if the validation fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
    
        // Fetch client details based on clientId, categoryId, and categorySlug
        if($request->input('categorySlug') == 'trademark') {
            $clientDetails = TrademarkUserModel::with('mainCategory:id,category_name,category_slug') // Eager load only necessary fields
    ->where('id', $request->input('clientId')) 
    ->where('category_id', $request->input('categoryId')) // Apply the condition on trademark_users.category_id
    ->first();
        }
        else {
            $clientDetails = null; // This is just a placeholder for other conditions
        }
    
        // Check if client details were found
        if (!$clientDetails) {
            return response()->json([
                'message' => 'Client not found or category does not match.'
            ], 404);
        }
    
        // Return client details as JSON response
        return response()->json([
            'clientDetails' => $clientDetails
        ], 200);
    }
    public function UpdateClientStatus(Request $request)
    {
        // Define validation rules for both fetching and updating status
        $validator = Validator::make($request->all(), [
            'clientId' => 'required|integer',
            'updateStatusMainCategory' => 'required|integer',
            'main_category_slug' => 'required|string',
            'clientstatus' => 'sometimes|integer', // Only required if status is being updated
        ]);
    
        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
    
        // Fetch client details based on clientId and categorySlug
        if ($request->input('main_category_slug') == 'trademark') {
            $clientDetails = TrademarkUserModel::where('id', $request->input('clientId'))
                ->where('category_id', $request->input('updateStatusMainCategory'))
                ->first();
        }
    
        // Check if client details were found
        if (!$clientDetails) {
            return response()->json([
                'message' => 'Client not found or category does not match.'
            ], 404);
        }
    
        // If clientstatus exists, update the status
        if ($request->has('clientstatus')) {
            $newStatus = $request->input('clientstatus');
    
            // Update client status
            $clientDetails->sub_category = $newStatus; // Assuming 'sub_category' is the correct field to update
            $result = $clientDetails->save(); // Save the updated model
    
            // Check if update was successful
            if ($result) {
                return response()->json(['success' => 'Status Updated Successfully']);
            } else {
                return response()->json(['error' => 'Failed to update status'], 500);
            }
        }
    
        // If no status update, return client details as JSON response
        return response()->json([
            'clientDetails' => $clientDetails
        ], 200);
    }
    public function searchCleint(Request $request) {
        if ($request->input('inputText')) {
            $searchValue = trim($request->input('inputText'));
            $query = TrademarkUserModel::where(function ($q) use ($searchValue) {
                $q->where('application_no', 'like', '%' . $searchValue . '%')
                  ->orWhere('file_name', 'like', '%' . $searchValue . '%')
                  ->orWhere('trademark_name', 'like', '%' . $searchValue . '%');
            })
            ->select('id', 'application_no', 'file_name', 'category_id');
            
            $results = $query->get();
            if ($results->isEmpty()) {
                return response()->json(['message' => 'No records found for this search.']);
            }
            return response()->json($results);
        }
    
        // Return a response if no inputText is provided
        return response()->json(['message' => 'Please provide a search query.']);
    }
    //client details of search
    public function searchClientDetails(Request $request)
    {
    $client_id = $request->input('client_id'); 
    return redirect()->route('admin.attorney.clientDetails', [
        'category_slug' => 'trademark',
        'id' => $client_id
    ]);
    }
    // update client status based on conditional fields
    public function getUpdateStatusConditionalFields($slug,$application_no){
        echo $application_no;
        echo $slug;
    }
    public function getAttoernyStatusWiseData($attorneyId,$category,$statusId){
        $attorney=AttorneysModel::find($attorneyId);
        $status=StatusModel::find($statusId);

        return view('admin_panel.reports.client_reports_status_wise_chart',compact('attorney','category','status'));
    }
      public function getAttoernyChartCountStatusWiseData(Request $request){
        if($request->input('category_slug') == 'trademark'){
        $query = TrademarkUserModel::with([
            'attorney:id,attorneys_name',
            'mainCategory:id,category_name,category_slug',
            'office:id,office_name',
            'statusMain:id,status_name',
            'subStatus:id,substatus_name',
            'clientRemark:id,client_remarks',
             'remarksMain:id,remarks as remarks as remarks_name',
            'Clientonsultant:id,consultant_name',
        ]);

      
        // Apply filters
        if ($request->filled('attorneyId')) {
            $query->where('attorney_id', $request->input('attorneyId'));
        }
    
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
    
      // Search functionality
if ($request->filled('search.value')) {
    $searchValue = trim($request->input('search.value'));
   
    // Apply the search to specific columns
    $query->where(function ($q) use ($searchValue) {
        $q->where('application_no', 'like', '%' . intval($searchValue) . '%') // For numeric field
            ->orWhere('trademark_name', 'like', '%' . $searchValue . '%') // For text field
            ->orWhere('file_name', 'like', '%' . $searchValue . '%'); // For another text field
    });
}

    
        // Apply ordering
        if ($request->has('order')) {
            $order = $request->input('order')[0];
            $columnIndex = $order['column'];
            $sortDirection = $order['dir'];
            $columns = $request->input('columns');
    
            if (isset($columns[$columnIndex])) {
                $columnName = $columns[$columnIndex]['name'];
                $query->orderBy($columnName, $sortDirection);
            }
        } else {
            $query->orderBy('id', 'asc');
        }
    
        // Pagination parameters
        $length = $request->input('length', 10);
        $start = $request->input('start', 0);
    
       
        // Get the filtered records count before applying pagination
        $filteredRecords = $query->count();
    
        // Apply pagination
        $data = $query->skip($start)->take($length)->get();
    
        // Total records in the database
        $totalRecords = TrademarkUserModel::count();
    
     // <button class="dropdown-item editStatus" data-id="' . $item->id . '" data-category-id="' . $item->mainCategory->id . '" data-category-slug="' . $item->mainCategory->category_slug . '">
                                    //     <i class="typcn typcn-edit"></i> Edit Status
                                    // </button>
                                    
                                    
        // Format the data
        $formattedData = $data->transform(function ($item, $index) use ($start) {
        
            return [
                'DT_RowIndex' => $start + $index + 1,
                'id' => $item->id,
                'application_no' => '<a href="' . route('admin.attorney.clientDetails', [
                    'category_slug' => $item->mainCategory->category_slug,
                    'id' => $item->id
                ]) . '">' . $item->application_no . '</a>',
                'file_name' => $item->file_name,
                'trademark_name' => $item->trademark_name,
                'phone_no' => $item->phone_no, // Include phone_no
                'email_id' => $item->email_id,
                'opponenet_applicant_name' => $item->opponenet_applicant_name,
                'valid_up_to' => $item->valid_up_to,
                'status' => $item->status->status_name ?? 'Not Filed',
                'filed_by' => $item->filed_by ?? ' ',
                'actions' => '<div class="dropdown dropstart">
                                <button class="btn btn-secondary p-1 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="typcn typcn-th-small"></i>
                                </button>
                                <div class="dropdown-menu">
                                   
                                    <a target="_blank" class="dropdown-item" href="' . route('admin.client-details.print-pdf', [
                                        'category_slug' => $item->mainCategory->category_slug,
                                        'id' => $item->id
                                    ]) . '">
                                        <i class="typcn typcn-document-add"></i> PDF Print
                                    </a>
                                 
                                     <a target="_blank" class="dropdown-item" href="' . route('admin.attorney.edit-clientDetails',['attoerny_id'=>$item->attorney_id,'category_slug'=>$item->mainCategory->category_slug,'id'=>$item->id]) . '">
                                        <i class="typcn typcn-edit"></i> Update Status
                                    </a>
                                    <a target="_blank" class="dropdown-item" href="' . route('admin.status.client-status', [
                                        'id' => $item->id
                                    ]) . '">
                                        <i class="typcn typcn-document-add"></i> Status Details
                                    </a>
                                    <a class="dropdown-item" href="' . route('admin.attorney.clientDetails', [
                                        'category_slug' => $item->mainCategory->category_slug,
                                        'id' => $item->id
                                    ]) . '">
                                        <i class="typcn typcn-edit"></i> Client Details
                                    </a>
                                </div>
                            </div>'
            ];
        });
    
        // Return JSON response for DataTables
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,  
            'recordsFiltered' => $filteredRecords, 
            'data' => $formattedData,       
        ]);
    }
    else{
        return response()->json([
            'status'=> 'Not Data Found',
        ]);
    }
    } 
    // block data function start here
    public function blockData(Request $request)
    {
        // Validate request data
        $request->validate([
            'dbtable' => 'required|string',
            'columnname' => 'required|string',
            'itemId' => 'required|integer',
        ]);
        $dbTable = $request->input('dbtable');
        $columnName = $request->input('columnname');
        $itemId = $request->input('itemId');
        $itemData = DB::table($dbTable)->where('id', $itemId)->first();
    
        if (!$itemData) {
            return response()->json(['success' => false, 'message' => 'Item not found.']);
        }
        $newValue = ($itemData->$columnName === 'yes') ? 'no' : 'yes';
        $updated = DB::table($dbTable)
            ->where('id', $itemId)
            ->update([$columnName => $newValue]);
    
        if ($updated) {
            return response()->json(['success' => true, 'message' => 'Item updated successfully.']);
        }
    
        return response()->json(['success' => false, 'message' => 'Failed to update the item.']);
    }

    // for another opposed number
    public function SaveDataForAnotherOpposedNumber(Request $request)
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
        $TrademarkUser['opposed_no'] = "";

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
            return redirect()->route('admin.attorney.edit-clientDetails', [
                'attoerny_id' => $TrademarkUser->attorney_id,
                'category_slug' => 'trademark',
                'id' => $TrademarkUser->id
            ])->with(['success' => 'User Registered Successfully Done']);
            
        }
    else{
        return redirect()->back()->with(['error' => 'User not Registerd Successfully Done']);
    }
        }
}
