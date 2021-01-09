<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactUsNotification extends Mailable
{
    use Queueable, SerializesModels;

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
        if($this->data['type']=='contact')
            return $this->from('contact@exceedmedia.com','Exceed Media Customer Support')
                        ->subject('Request Contact Notification')
                        ->view('email.admin-contactusmail', ['data'=>$this->data]);
        else
            return $this->from('contact@exceedmedia.com','Exceed Media Customer Support')
                        ->subject('Request Quote Notification')
                        ->view('email.admin-quotesmail', ['data'=>$this->data]);
    }
}
