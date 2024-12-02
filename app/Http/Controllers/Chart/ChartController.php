<?php

namespace App\Http\Controllers\Chart;

use App\Http\Controllers\Controller;
use App\Models\StatusModel;
use Illuminate\Http\Request;
use App\Models\TrademarkUserModel;
use Illuminate\Support\Facades\DB;
class ChartController extends Controller
{
    public function categoryWiseClientChart(){

       $userCount=TrademarkUserModel::count();
        $chartData = [
            'labels' => ['Trademark','Copyright','Design'],
            'userCount' => [$userCount,0,0]
        ];

        if($chartData){
        return response()->json($chartData);
    }
    }
    public function statusWisewiseClientChart(){
        $statusCounts = StatusModel::withCount('trademarkUsers') // Count related users for each status
        ->get();


        $chartData = [
            'labels' => [],
            'count' => [],
        ];

        foreach ($statusCounts as $status) {
           
            $chartData['labels'][] = $status->status_name; 
            $chartData['count'][] = $status->trademark_users_count;  
        }

        if($chartData){
            return response()->json($chartData);
        }
    }
}
