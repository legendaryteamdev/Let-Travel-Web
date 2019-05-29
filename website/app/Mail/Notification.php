<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class Notification extends Mailable
{
    use Queueable, SerializesModels;
    var $subject = "";
    var $data = [];
    var $template = "";
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject = "", $data = [], $template = "")
    {   
        $this->subject = $subject;
        $this->data = $data; 
        $this->template = $template; 
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {    
       
        return $this->markdown($this->template)->subject($this->subject)->with($this->data);
    }
}
