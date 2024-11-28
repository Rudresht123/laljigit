<?php

namespace App\Http\Controllers\datatable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DataTableController extends Controller
{
    public function CommonTable(Request $request)
    {
        $tbTable = $request->input('db_table');
        if ($tbTable) {
            $data = DB::table($tbTable);
            
            // Apply search filter if provided
            if ($request->filled('search.value')) {
                $searchValue = trim($request->input('search.value'));
                $data->where(function ($q) use ($searchValue,$tbTable) {
                    $columns = Schema::getColumnListing($tbTable); // Use the dynamic table name
                    foreach ($columns as $column) {
                        $q->orWhere($column, 'like', '%' . $searchValue . '%');
                    }
                });
            }
    
            // Apply order by
            if ($request->has('order')) {
                $order = $request->input('order')[0];
                $columnIndex = $order['column'];
                $sortDirection = $order['dir'];
                $columns = $request->input('columns');
                
                if (isset($columns[$columnIndex])) {
                    $columnName = $columns[$columnIndex]['name'];
                    if ($columnName !== 'DT_RowIndex') {
                        $data->orderBy($columnName, $sortDirection);
                    }
                }
            } else {
                $data->orderBy('id', 'asc'); // Default ordering
            }
    
            // Pagination
            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
    
            $filteredRecords = $data->count();
            $data = $data->skip($start)->take($length)->get();
            $totalRecords = DB::table($tbTable)->count();
    
            // Format data dynamically


            $formattedData = $data->transform(function ($item, $index) use ($start, $request) {
                            
                $columns = $request->input('columns'); // Corrected typo
                foreach ($columns as $column) {
                    if ($column['data'] === 'is_active') {
                        // Format 'is_active' column with badge
                        $formattedRow['is_active'] = $item->is_active == 'yes'
                            ? '<span class="badge text-bg-success">Active</span>'
                            : '<span class="badge text-bg-danger">De-Active</span>';
                    }
                    elseif($column['data'] === 'status') {
                        // Format 'is_active' column with badge
                        $formattedRow['status'] = $item->status == 'yes'
                            ? '<span class="badge text-bg-success">Active</span>'
                            : '<span class="badge text-bg-danger">De-Active</span>';
                    }
                   else {
                        // Dynamically add the column data
                        $columnName = $column['data'];
                        $formattedRow[$columnName] = $item->$columnName ?? ''; // Handle undefined columns safely
                    }
                }
    

                // Add actions buttons
                $formattedRow['actions'] = '
                                            <td class="d-flex justify-content-center">
                <a href="" class="editButton" data-id="'. $item->id .'"
                    class="text-primary p-1 rounded fw-bold "><i class="far fa-edit"></i></a>
                <a href="" data-id="'. $item->id.'"
                    class="deletebutton text-danger p-1 rounded fw-bold "><i
                        class="fa fa-trash"></i></a>
            </td>
                                            ';
    
                return $formattedRow;
            });

            Log::info($formattedData);
    
            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $formattedData
            ]);
        } else {
            return response()->json('Table is not Defined');
        }
    }
      
}
