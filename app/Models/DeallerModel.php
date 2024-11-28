<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeallerModel extends Model
{
    use HasFactory;
    protected $table="deal_with";
    protected $fillable=[
        'dealler_name',
        'status'
    ];
}
