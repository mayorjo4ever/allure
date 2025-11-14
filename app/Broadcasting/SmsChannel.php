<?php

namespace App\Broadcasting;

use App\Models\Admin;
use Illuminate\Notifications\Notification; 

class SmsChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(Admin $user): array|bool
    {
        //
    }
}
