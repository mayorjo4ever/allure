<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;
  
class SendSmsNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
     public function via($notifiable)
    {
        return [\App\Channels\SmsChannel::class];
    }

    public function toSms($notifiable)
    {
        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

        return $twilio->messages->create($notifiable->routeNotificationFor('sms'), [
            'from' => env('TWILIO_PHONE_NUMBER'),
            'body' => $this->message,
        ]);
    }
    
    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}




/*****************/
  