<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;

class SmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        if (method_exists($notification, 'toSms')) {
            return $notification->toSms($notifiable);
        }
    }
}

#127,963