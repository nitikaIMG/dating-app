<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $view;
    public $subject;
    /**
     * Create a new message instance.
     */
    public function __construct($data, $view, $subject)
    {
        $this->data = $data;
        $this->view = $view;
        $this->subject = $subject;
    }

    public function build()
    {
        return $this->view($this->view)
        ->subject($this->subject);
    }

    /**
     * Get the message envelope.
     */
//     public function envelope(): Envelope
//     {
//         return new Envelope(
//             subject: 'Email Verify Mail',
//         );
//     }

//     /**
//      * Get the message content definition.
//      */
//     public function content(): Content
//     {
//         return new Content(
//             view: 'view.name',
//         );
//     }

//     /**
//      * Get the attachments for the message.
//      *
//      * @return array<int, \Illuminate\Mail\Mailables\Attachment>
//      */
//     public function attachments(): array
//     {
//         return [];
//     }
 }
