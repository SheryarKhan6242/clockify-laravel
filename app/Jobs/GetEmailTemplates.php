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
use App\Models\EmailTemplate;



class GetEmailTemplates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $templateName;
    public $placeholders;
    public $values;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $templateName, $placeholders, $values)
    {
        $this->user = $user;
        $this->templateName = $templateName;
        $this->placeholders = $placeholders;
        $this->values = $values;        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Get Email Content and send email
        $template = EmailTemplate::where('name', $this->templateName)->first();
        $subject = $template->subject;
        $emailBody = $template->body;
        $emailBody = str_replace($this->placeholders, $this->values, $emailBody);
        Mail::to($this->user->email)->send(new SendEmail($subject, $emailBody));
    }
}
