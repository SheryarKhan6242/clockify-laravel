<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail; 



class SendVerifiedOtpEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public $otp;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $otp)
    {
        //
        $this->email = $email;
        $this->otp = $otp;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subject = 'Forget Password OTP';
        $content = 'Your OTP is: ' . $this->otp;
        
        Mail::to($this->email)->send(new SendEmail($subject, $content));
    }
}
