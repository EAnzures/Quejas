<?php

namespace App\Mail;

use Illuminate\Support\Facades\Http;

class BrevoMailer
{
    public static function send(string $to, string $subject, string $htmlContent): void
    {
        Http::withHeader('api-key', config('services.brevo.key'))
            ->post('https://api.brevo.com/v3/smtp/email', [
                'sender' => [
                    'name'  => config('mail.from.name'),
                    'email' => config('mail.from.address'),
                ],
                'to'          => [['email' => $to]],
                'subject'     => $subject,
                'htmlContent' => $htmlContent,
            ])
            ->throw();
    }
}
