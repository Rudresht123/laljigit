<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubStatusModel extends Model
{
    use HasFactory;
    protected $table="sub_status";
    protected $fillable = [
        'main_status_id',
        'substatus_name',
        'slug',
        'substatus_remarks',
        'status'
    ]; 
}
