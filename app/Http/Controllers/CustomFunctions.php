<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubcategoryModel;
use App\Models\SubStatusModel;
use App\Models\TrademarkUserModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            'status:id,status_name',
            'subStatus:id,substatus_name',
            'clientRemark:id,client_remarks',
            'remarks:id,remarks',
            'consultant:id,consultant_name',
            'status:id,status_name' // Ensure this is included for 'status'
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
                $q->where('email_id', 'like', '%' . $searchValue . '%')
                    ->orWhere('application_no', 'like', '%' . intval($searchValue) . '%')
                    ->orWhere('trademark_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('file_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('phone_no', 'like', '%' . $searchValue . '%');
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
    
        $filteredRecords = $query->count();
        $data = $query->skip($start)->take($length)->get();
        $totalRecords = TrademarkUserModel::count();
    
        // Format the data
        $formattedData = $data->transform(function ($item, $index) use ($start) {
            return [
                'DT_RowIndex' => $start + $index + 1,
                'id' => $item->id,
                'application_no' => $item->application_no,
                'file_name' => $item->file_name,
                'trademark_name' => $item->trademark_name,
                'phone_no' => $item->phone_no, // Include phone_no
                'email_id' => $item->email_id,
                'opponenet_applicant_name' => $item->opponenet_applicant_name,
                'valid_up_to' => $item->valid_up_to,
                'status' => $item->status->status_name ?? 'Not Filed',
                'filed_by' => $item->filed_by ?? '', // Ensure 'mainstatus' relation is loaded
                'actions' => '<div class="dropdown dropstart">
                                <button class="btn btn-secondary p-1 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="typcn typcn-th-small"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <button class="dropdown-item editStatus" data-id="' . $item->id . '" data-category-id="' . $item->mainCategory->id . '" data-category-slug="' . $item->mainCategory->category_slug . '">
                                        <i class="typcn typcn-cog-outline"></i> Edit Status
                                    </button>
                                    <a target="_blank" class="dropdown-item" href="' . route('admin.client-details.print-pdf', [
                                        'category_slug' => $item->mainCategory->category_slug,
                                        'application_no' => $item->application_no
                                    ]) . '">
                                        <i class="typcn typcn-document-add"></i> PDF Print
                                    </a>

                                      <a target="_blank" class="dropdown-item" href="' . route('admin.status.client-status', [
                                        'application_no' => $item->application_no
                                    ]) . '">
                                        <i class="typcn typcn-document-add"></i> Status Details
                                    </a>

                                    
                                    <a class="dropdown-item" href="' . route('admin.attorney.clientDetails', [
                                        'category_slug' => $item->mainCategory->category_slug,
                                        'application_no' => $item->application_no
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
            'data' => $formattedData
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

            // $clientDetails = TrademarkUserModel::join('main_category', 'trademark_users.category_id', '=', 'main_category.id')
            //     ->where('trademark_users.id', $request->input('clientId')) // Fully qualify 'id' with table name
            //     ->where('trademark_users.category_id', $request->input('categoryId')) // Fully qualify 'category_id' with table name
            //     ->select('trademark_users.*', 'main_category.category_name as main_category_name','main_category.category_slug as main_category_slug') // Add any other columns from main_category you need
            //     ->first();
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
                $columns = Schema::getColumnListing('trademark_users');
                foreach ($columns as $column) {
                    if ($column === 'firm_name') {
                        continue;
                    }
                    $q->orWhere($column, 'like', '%' . $searchValue . '%');
                }
            })
            ->select('id', 'application_no','file_name','category_id');
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
    $application_no = $request->input('application_no');
    
    // Perform some action, then redirect to client details page
   
     
   
    
    return redirect()->route('admin.attorney.clientDetails', [
        'category_slug' => 'trademark',
        'application_no' => $application_no
    ]);
}
 
    
    
    
}
