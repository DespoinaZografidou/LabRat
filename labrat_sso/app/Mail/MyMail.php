<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MyMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $reciever;
    public $subject;
    /**
     * Create a new message instance.
     *
     * @param  array  $data
     * @param  string $subject
     * @return void
     */
    public function __construct($data,$reciever)
    {
       $this->data=$data;
        $this->reciever=$reciever;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('icsd16041@icsd.aegean.gr')
            ->to($this->reciever)
            ->subject('LabRat Login Information')
            ->markdown('emails.mail')->with(['data'=>$this->data]);

    }
}
