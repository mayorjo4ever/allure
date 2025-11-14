<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TermiiSmsService
{
    public function send($to, $message)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post('https://api.ng.termii.com/api/sms/send', [
            'to' => $to,
            'from' => config('services.termii.sender_id'),
            'sms' => $message,
            'type' => 'plain',
            'channel' => 'generic',
            'api_key' => config('services.termii.api_key'),
        ]);
         # base_url = https://v3.api.termii.com/
        return $response->json();
    }
}
