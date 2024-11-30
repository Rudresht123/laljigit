<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\TrademarkUserModel;
use Illuminate\Http\Request;

class StatusHistoryController extends Controller
{
    public function getStatusHistory($application_no){
        $application = TrademarkUserModel::with('statusHistories')->where('application_no', $application_no)->first();
      

        echo "<pre>";
        print_r($application->statusHistories);
        die();

    }
}
