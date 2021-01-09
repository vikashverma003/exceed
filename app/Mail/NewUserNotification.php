<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewUserNotification extends Mailable
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
        $email_token = base64_encode($this->data->email);
        $name = $this->data->name;
        return $this->from('admin@exceedmedia.com','Exceed Media Customer Support')
                    ->subject('New Account Notification')
                    ->view('email.email-verify', ['email_token'=>$email_token,'name'=>$name]);
    }
}
