<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PatientWelcomeNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly string $plainPassword
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Welcome to HMS Patient Portal')
            ->greeting('Welcome, ' . ($notifiable->name ?? 'Patient') . '!')
            ->line('Your patient portal account has been created. Use the credentials below to sign in.')
            ->line('Email: ' . ($notifiable->email ?? ''))
            ->line('Password: ' . $this->plainPassword)
            ->line('For security, please change your password after your first login.')
            ->action('Open Patient Portal', url('/?login=1'))
            ->line('If you did not create this account, please contact the hospital support team.');
    }
}

