<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\StatusModel;
use App\Models\SubStatusModel;
use App\Models\TrademarkUserModel;
use Illuminate\Http\Request;

class StatusHistoryController extends Controller
{
    public function getStatusHistory($application_no){
        $statusHistory = TrademarkUserModel::with('statusHistories')->where('application_no', $application_no)->first();
        $status=StatusModel::where('status','yes')->get();
        $substatus=SubStatusModel::where('status','yes')->get();

        if($statusHistory){
            return view("admin_panel.users.status_history",compact("statusHistory","status","substatus"));
        }
        else{
            return redirect()->back()->with("error","Status CaseFile Is Not Found");
        }

    }
}
