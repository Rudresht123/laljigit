<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultantModel extends Model
{
    use HasFactory;
    protected $table="consultant";
    protected $fillable=[
        'consultant_name',
        'status'
    ];
}
