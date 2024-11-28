<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusModel extends Model
{
    use HasFactory;
    protected $table="status";
    protected $fillable=[
        'status_name',
        'slug',
        'remark',
        'status'
    ];
    public function trademarkUsers()
    {
        return $this->hasMany(TrademarkUserModel::class, 'status');
    }

}
