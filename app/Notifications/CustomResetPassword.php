<?php
namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class CustomResetPassword extends BaseResetPassword
{
    /**
     * Get the notification mail message for the given token.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset()
        ], false));

        return (new MailMessage)
            ->subject(Lang::get('Reset Password Notification'))
            ->view('admin_panel.auth.password_reset_link', ['url' => $url, 'name' => $notifiable->name]);
    }
}
