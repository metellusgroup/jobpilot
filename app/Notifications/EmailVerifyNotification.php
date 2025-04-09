<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerifyNotification extends Notification
{
    public $email;

    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $type = 'email_verify';
        $formatted_mail_data = getFormattedTextByType($type, [
            'verify_email' => route('verification.verify', $this->token),
        ]);

        // Debugging to check if it's returning valid data

        $subject = $formatted_mail_data['subject'];
        $message = $formatted_mail_data['message'];

        return (new MailMessage)
            ->subject($subject)
            ->greeting('Hello!')
            ->line('Thank you for signing up. Please verify your email address by clicking the button below:')
            ->action('Verify Email', url('verify-email/'.$this->token))
            ->view('mails.email-template', ['content' => $message]); // Ensure this view exists
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
