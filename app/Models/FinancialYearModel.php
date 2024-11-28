<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialYearModel extends Model
{
    use HasFactory;
    protected $table="financial_year";
    protected $fillable=[
        'financial_session',
        'start_date',
        'end_date',
        'is_active',
        'crated_at',
        'updated_at'
    ];
}
