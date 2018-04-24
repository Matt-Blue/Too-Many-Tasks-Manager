<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;


use Mail;

class DemoEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $demo;


    public function __construct($demo)
    {
        $this->demo = $demo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user_id = Auth::id();
        $tasks = \App\Task::orderBy('date', 'desc')->get()->where('user_id', $user_id);
        
        return $this->from('migrepereira@gmail.com')
                    ->view('mails.demo')
                    ->text('mails.demo_plain')
                    ->with([
                        'tasks' => $tasks

                    ]);

                    
    }
}
