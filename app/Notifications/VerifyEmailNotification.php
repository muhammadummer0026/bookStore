<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailNotification extends Notification
{
    public function toMail($notifiable)
    {
        $verificationUrl = route('verify.email', ['token' => $notifiable->verify_token]);

        return (new MailMessage)
            ->subject('Verify Your Email')
            ->markdown('emails.verification', ['verificationUrl' => $verificationUrl]);
    }
}
