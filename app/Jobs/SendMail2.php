<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use PDF;
use App\Mail\TutorialMail2;

class SendMail2 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $name;
    public $email;
    public $users;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->users = $data['users'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $email = new TutorialMail2($this->name,$this->users);
        Mail::to($this->email)->send($email);
    }
}
