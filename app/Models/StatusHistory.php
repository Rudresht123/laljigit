<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    use HasFactory;

    protected $table="client_status_history";
    protected $fillable = [
        'application_no',
        'file_name',
        'status_history',
    ];
}
