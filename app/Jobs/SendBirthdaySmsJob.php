<?php

namespace App\Jobs;

use App\Models\SmsLog;
use App\Models\User;
use App\Services\TermiiSmsService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendBirthdaySmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    
    
    /**
     * Execute the job.
     */

    public function handle(TermiiSmsService $smsService)
    {
        $today = Carbon::now()->toDateString();

        // Prevent duplicates
        $alreadySent = SmsLog::where('user_id', $this->user->id)
            ->where('type', 'birthday')
            ->where('sent_date', $today)
            ->exists();

        if ($alreadySent) return;

        $message = "Happy Birthday, {$this->user->surname}, {$this->user->firstname} {$this->user->othername} ! 🎉 Wishing you a joyful and blessed day!";
        $smsService->send($this->user->phone, $message);

        SmsLog::create([
            'user_id' => $this->user->id,
            'phone' => $this->user->phone,
            'message' => $message,
            'type' => 'birthday',
            'sent_date' => $today,
        ]);
    }
}
 