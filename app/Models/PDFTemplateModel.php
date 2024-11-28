<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PDFTemplateModel extends Model
{
    use HasFactory;
    protected $table="pdf_templates";
    protected $fillable=[
        'template_name',
        'template_slug',
        'content',
        'template_logo',
        'template_watermark',
        'is_active'
    ];   
}
