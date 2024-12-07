<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExcelColumnNameModel extends Model
{
    protected $table = "excelcolumn_name";
    protected $fillable = ["column_name","excelcolumn_name","status"];
}
