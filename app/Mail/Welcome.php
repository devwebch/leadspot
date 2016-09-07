<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class Welcome extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->subject("Let's get you started [LeadSpot]");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user_first_name    = Auth::user()->first_name;
        $user_last_name     = Auth::user()->last_name;

        return $this->view('emails.welcome', ['first_name' => $user_first_name, 'last_name' => $user_last_name]);
    }
}
