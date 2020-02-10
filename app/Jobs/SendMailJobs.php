<?php

namespace App\Jobs;

use App\Mail\SendMail;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMailJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $body;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $body)
    {
        $this->email = $email;
        $this->body  = $body;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new SendMail(array('mailBody' => $this->body)));
    }
}
