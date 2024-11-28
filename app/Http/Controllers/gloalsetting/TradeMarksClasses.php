<?php
namespace App\Http\Controllers\gloalsetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TradeMarkClassModel;

class TradeMarksClasses extends Controller
{
    public function TrademarkClass()
    {
        $classes=TradeMarkClassModel::get();
        return view('admin_panel.global_setting.trademarkClasses.index',compact('classes'));
    }
}
