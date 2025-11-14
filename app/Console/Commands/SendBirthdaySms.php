<?php

namespace App\Console\Commands;

use App\Jobs\SendBirthdaySmsJob;
use App\Models\User;
use App\Services\TermiiSmsService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendBirthdaySms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-birthday-sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send birthday greetings via SMS to users whose birthday is today';

    /**
     * Execute the console command.
     */
    
     protected $smsService;
     
     public function __construct(TermiiSmsService $smsService)
        {
            parent::__construct();
            $this->smsService = $smsService;
        }
        
    public function handle() {
        $today = Carbon::now()->format('m-d');
        $todayDate = Carbon::now()->toDateString();
        
        $users = User::whereRaw("DATE_FORMAT(birthdate, '%m-%d') = ?", [$today])->get();
        
        foreach ($users as $user):
             SendBirthdaySmsJob::dispatch($user);
        endforeach;
            
    }
}