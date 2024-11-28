<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $tableName;
    protected $userId;

    public function __construct($tableName, $userId)
    {
        $this->tableName = $tableName;
        $this->userId = $userId;

        // Fetch mail template settings
        $mailTemplate = DB::table($this->tableName)->where('slug', 'registration_email')->first();

        // Check if mail template is not null
        if ($mailTemplate) {
            // Dynamically set 'from' address
            $this->from(
                $mailTemplate->from_email ?? config('mail.from.address'), // Fallback to config
                $mailTemplate->from_name ?? config('mail.from.name') // Fallback to config
            );
        } else {
            Log::error('Mail template not found for slug: registration_email in table: ' . $this->tableName);
            // Fallback to default 'from' address if template is not found
            $this->from(config('mail.from.address'), config('mail.from.name'));
        }
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Client Registration Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'admin_panel.mailTemp.registration',
            with: [
                'table' => $this->tableName,
                'userId' => $this->userId
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
