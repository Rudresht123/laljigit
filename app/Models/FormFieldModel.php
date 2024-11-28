<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormFieldModel extends Model
{
    use HasFactory;
    protected $table="category_form";
    protected $fillable=[
        'category_id',
        'field_label',
        'field_name',
        'field_type',
        'field_options',
        'is_required',
        'field_order'
    ];
}
