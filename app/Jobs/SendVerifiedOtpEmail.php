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

    public $user;
    public $otp;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $otp)
    {
        //
        $this->user = $user;
        $this->otp = $otp;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subject = 'Password Reset One-Time Password (OTP)';
        $content = ' Dear <strong>' . $this->user->name . '</strong>,<br>
            This email is in response to your request to reset your password. Please find below the One-Time Password (OTP) required to proceed with the password reset process:
            OTP: <strong>' .$this->otp .'</strong>
            <br>
            Please note that this OTP is valid for a limited time only. Use it promptly to reset your password. If you did not initiate this password reset request, please ignore this email and ensure the security of your account.
            <br>
            If you need any further assistance or have any questions, please contact our support team immediately.
            <br>
            Thank you.
            <br>
            Best regards,<br>
            Management 
        ';
        
        Mail::to($this->user->email)->send(new SendEmail($subject, $content));
    }
}
