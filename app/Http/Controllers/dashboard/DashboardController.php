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



        $trademarkuserrenewal = TrademarkUserModel::where('sub_category', 4)
        ->join('consultant', 'trademark_users.consultant', '=', 'consultant.id')
        ->join('main_category', 'trademark_users.category_id', '=', 'main_category.id')
        ->select(
            'trademark_users.*', 
            'consultant.consultant_name as consultant_name',
            'main_category.category_slug as category_slug' )
            ->get();


            
        return view('admin_panel.dashboard',compact('attoernyes','trademarkuserrenewal','groupedData','mcategories','consultant','subcategory'));
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
