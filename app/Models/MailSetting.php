<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailSetting extends Model
{
    use HasFactory;
    protected $table="email_config";
    protected $fillable=[
            'mail_encription',
            'mail_mailer',
            'mail_host',
            'mail_port',
            'mail_username',
            'mail_password',
            'mail_fromaddress',
            'mail_fromname' 
    ];
}
