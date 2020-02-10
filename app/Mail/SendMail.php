<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        extract($this->data);

        if(isset($attachment))

            return $this->view('sendMail.mailTemplate', $this->data)
                ->subject('Laravel 6 Mail Test Subject')->attach($attachment,
                [
                    'as'   => $as,
                    'mime' => $mime,
                ]);

        else

            return $this->view('sendMail.mailTemplate', $this->data)
                ->subject('Laravel 6 Mail Test Subject');
        
    }
}
