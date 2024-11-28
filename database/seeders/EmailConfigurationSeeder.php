<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MailSetting;

class EmailConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MailSetting::create([
            'mail_encription' => 'tls',
            'mail_mailer' => 'smtp',
            'mail_host' => 'sandbox.smtp.mailtrap.io',
            'mail_port' => '2525',
            'mail_username' => '47c0adc49e1293',
            'mail_password' => 'ceb39fa8baee5a',
            'mail_fromaddress' => 'rudershtiwari8@gmail.com',
            'mail_fromname' => 'Rudresh Tiwari' 
        ]);
    }
}
