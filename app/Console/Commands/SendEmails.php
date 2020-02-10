<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Mail\SendMail;
use Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sendemails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send drip e-mails to a user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $mailBody = 'Queue mail testing';

        Mail::to('birendra.singh@massoftind.com')->send(new SendMail(array('mailBody' => $mailBody)));
    }
}
