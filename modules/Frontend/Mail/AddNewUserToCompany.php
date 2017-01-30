<?php

namespace Modules\Frontend\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AddNewUserToCompany extends Mailable
{
    use Queueable, SerializesModels;

    public $url;

    public function __construct($token)
    {
        $this->url = route('frontend.accept_invitation.acceptInvitation', ['token' => $token]);
    }

    public function build()
    {
        return $this->view('frontend::emails.user_invitation');
    }
}