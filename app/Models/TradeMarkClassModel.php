<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeMarkClassModel extends Model
{
    use HasFactory;
    protected $table="trademark_classes";
    protected $fillable=[
        'id',
        'class_name',
        'desciption'
    ];
}
