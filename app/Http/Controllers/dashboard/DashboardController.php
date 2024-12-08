<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\gloalsetting\TradeMarksClasses;
use App\Models\AttorneysModel;
use App\Models\TrademarkUserModel;
use App\Models\MainCategoryModel;
use App\Models\ConsultantModel;
use App\Models\SubcategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mcategories = MainCategoryModel::where('status', 'yes')->get();
        $consultant = ConsultantModel::where('status', 'yes')->get();
        $subcategory = SubcategoryModel::get();
        $attoernyes=AttorneysModel::get();
        $groupedData = TrademarkUserModel::with([
            'mainCategory:*',
            'statusMain:*'
        ])->get();

        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->addWeek()->endOfDay();
        $upcominglastdatevalidupto=TrademarkUserModel::with([
            'Clientonsultant:id,consultant_name',
             'statusMain:id,status_name',
            'mainCategory:id,category_name'
        ])->whereBetween('valid_up_to',[$startDate,$endDate])->get();
        $upcominglastdateoppositionhearingdate=TrademarkUserModel::with([
            'Clientonsultant:id,consultant_name',
            'statusMain:id,status_name',
            'mainCategory:id,category_name'
        ])->whereBetween('opposition_hearing_date',[$startDate,$endDate])->get();

        $upcommingdates=['valid_upto'=>$upcominglastdatevalidupto,'opposition-hearing_date'=>$upcominglastdateoppositionhearingdate];
                 
        return view('admin_panel.dashboard',compact('attoernyes','groupedData','mcategories','consultant','subcategory','upcommingdates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {


    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
