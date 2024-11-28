<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use App\Models\MailSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $mailSetting = MailSetting::first();
        
        if ($mailSetting) {
            $data = [
                'transport' => $mailSetting->mail_mailer,
                'host' => $mailSetting->mail_host,
                'port' => $mailSetting->mail_port,
                'encryption' => $mailSetting->mail_encription,
                'username' => $mailSetting->mail_username,
                'password' => $mailSetting->mail_password,
                'from' => [
                    'address' => $mailSetting->mail_fromaddress,
                    'name' => $mailSetting->mail_fromname,
                ],
            ];
             Config::set('mail.mailers.smtp', $data); // Adjust 'smtp' based on your mail driver
            Config::set('mail.default', $mailSetting->mail_mailer); // Adjust as per your default mailer  
        }
    }
}
