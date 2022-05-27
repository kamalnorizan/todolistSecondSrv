<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;
class TutorialMail2 extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $users;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $users)
    {
        $this->name = $name;
        $this->users = $users;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $users = $this->users;
        $pdf = PDF::loadView('mail.users',compact('users'));
        return $this->view('mail.test1')
        ->attachData($pdf->output(),'SenaraiPengguna.pdf');
    }
}
