<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientRemarksModel extends Model
{
    use HasFactory;
    protected $table="client_remarks";
    protected $fillable=[
        'client_remarks',
        'status'
    ];
}
