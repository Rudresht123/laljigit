<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\AttorneysModel;
use App\Models\MainCategoryModel;
use App\Models\ConsultantModel;
use App\Models\StatusModel;
use App\Models\SubcategoryModel;
use Illuminate\Http\Request;

class ClientsReports extends Controller
{
    public function Clients(){
       
            $attorneys = AttorneysModel::all();
            $statuss = StatusModel::where('status', 'yes')->get();
            $mcategories = MainCategoryModel::where('status', 'yes')->get();
            $subcategory = SubcategoryModel::get();
        
            return view('admin_panel.reports.client_reports', compact('attorneys', 'statuss', 'mcategories','subcategory'));
    }
}
