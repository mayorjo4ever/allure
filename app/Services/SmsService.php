<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use function config;

class SmsService
{
    protected $apiKey;
    protected $senderId;

    public function __construct()
    {
        $this->apiKey = config('services.sendchamp.api_key');
        $this->senderId = config('services.sendchamp.sender_id');
    }

    public function sendSms($to, $message)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.sendchamp.com/api/v1/sms/send', [
            'to'      => [$to],
            'message' => $message,
            'sender_id' => $this->senderId,
        ]);
        # 

        return $response->successful();
    }
}
