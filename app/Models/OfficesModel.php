<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficesModel extends Model
{
    use HasFactory;
    protected $table="offices";
    protected $fillable=[
        'office_name',
        'status'
    ];
}
