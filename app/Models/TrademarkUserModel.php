<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrademarkUserModel extends Model
{
    use HasFactory;

    protected $table="trademark_users";
    protected $fillable=[
        'attorney_id',
        'category_id',
        'application_no',
        'file_name',
        'trademark_name',
        'trademark_class',
        'opposition_no',
        'filling_date',
        'phone_no',
        'email_id',
        'objected_hearing_date',
        'opponenet_applicant_name',
        'opponent_applicant',
        'opponent_applicant_code',
        'hearing_date',
        'rectification_no',
        'opposed_no',
        'examination_report',
        'opposition_hearing_date',
        'valid_up_to',
        'status',
        'opp_status',
        'sub_status',
        'client_remarks',
        'remarks',
        'consultant',
        'deal_with',
        'filed_by',
        'client_remarks',
        'remarks',
        'financial_year',
        'created_at',
        'updated_at',
        'office_id',
        'sub_category',
        'ip_field',
        'email_remarks',
        'evidence_last_date',
        'client_communication',
        'mail_recived_date',
        'mail_recived_date_2'	
    ];

    public function attorney()
    {
        return $this->belongsTo(AttorneysModel::class, 'attorney_id');
    }
    
    public function mainCategory()
    {
        return $this->belongsTo(MainCategoryModel::class, 'category_id');
    }
    
    public function status()
    {
        return $this->belongsTo(StatusModel::class, 'status');
    }
    
    public function subStatus()
    {
        return $this->belongsTo(SubStatusModel::class, 'sub_status');
    }
    
    public function remarks()
    {
        return $this->belongsTo(RemarksModel::class, 'remarks');
    }
    public function clientRemark()
    {
        return $this->belongsTo(ClientRemarksModel::class, 'client_remarks');
    }
    
    public function financialYear()
    {
        return $this->belongsTo(FinancialYearModel::class, 'financial_year');
    }
    
    public function consultant()
    {
        return $this->belongsTo(ConsultantModel::class, 'consultant');
    }
    
    public function office()
    {
        return $this->belongsTo(OfficesModel::class, 'office_id');
    }
    
    public function subCategory()
    {
        return $this->belongsTo(SubCategoryModel::class, 'sub_category');
    }
        public function dealWith()
    {
        return $this->belongsTo(SubcategoryModel::class, 'deal_with','id');
    }
    public function statusHistories()
{
    return $this->belongsTo(StatusHistory::class, 'application_no', 'application_no');
}
}
