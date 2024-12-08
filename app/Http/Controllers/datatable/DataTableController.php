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

        // Check if the table has the columns 'is_active' and 'status'
        $hasIsActive = Schema::hasColumn($tbTable, 'is_active');
        $hasStatus = Schema::hasColumn($tbTable, 'status');

        // Apply search filter if provided
        if ($request->filled('search.value')) {
            $searchValue = trim($request->input('search.value'));
            $data->where(function ($q) use ($searchValue, $tbTable) {
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
        $formattedData = $data->transform(function ($item, $index) use ($start, $request, $hasIsActive, $hasStatus) {
            $columns = $request->input('columns');
            $formattedRow = [];

            foreach ($columns as $column) {
                $columnName = $column['data'];
                if ($columnName === 'is_active' && $hasIsActive) {
                    $formattedRow['is_active'] = $item->is_active == 'yes'
                        ? '<span class="badge text-bg-success">Active</span>'
                        : '<span class="badge text-bg-danger">De-Active</span>';
                } elseif ($columnName === 'status' && $hasStatus) {
                    $formattedRow['status'] = $item->status == 'yes'
                        ? '<span class="badge text-bg-success">Active</span>'
                        : '<span class="badge text-bg-danger">De-Active</span>';
                } else {
                    $formattedRow[$columnName] = $item->$columnName ?? '';
                }
            }

            // Add action buttons
            $formattedRow['actions'] = '
                <td class="d-flex justify-content-center">
                    <a href="" class="editButton" title="Edit Data" data-id="' . $item->id . '"
                       class="text-primary p-1 rounded fw-bold "><i class="far fa-edit"></i></a>';

            if (($hasIsActive && $item->is_active == 'yes') || ($hasStatus && $item->status == 'yes')) {
                $formattedRow['actions'] .= '
                    <a href="" title="Block Data" class="blockButton ms-1 text-danger" data-id="' . $item->id . '"
                       class="text-danger p-1 rounded fw-bold "><i class="fa fa-ban text-danger" aria-hidden="true"></i></a>';
            } else {
                $formattedRow['actions'] .= '
                    <a href="" title="Un Block Data" class="blockButton ms-1 text-success" data-id="' . $item->id . '"
                       class="text-success p-1 rounded fw-bold "><i class="fa fa-unlock" aria-hidden="true"></i></a>';
            }

            $formattedRow['actions'] .= '
                <a href="" style="display:none" data-id="' . $item->id . '"
                   class="deletebutton hidden text-danger p-1 rounded fw-bold "><i class="fa fa-trash"></i></a>
                </td>
            ';

            return $formattedRow;
        });

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $formattedData,
        ]);
    } else {
        return response()->json('Table is not Defined');
    }
}

      
}
