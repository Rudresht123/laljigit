<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttorneysModel extends Model
{
    use HasFactory;
    protected $table="attorneys";
    protected $fillable=[
        'attorneys_name',
        'gender',
        'email',
        'phone_number',
        'specialization',
        'license_number', 
        'bar_admission_date', 
        'profile_picture',
        'bio',
        'created_at',
        'updated_at'
    ];
    public function trademarkUsers()
{
    return $this->hasMany(TrademarkUserModel::class, 'attorney_id'); 
}
}
