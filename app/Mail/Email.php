<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    public $data = [];
    /**
     * Create a new message instance.
     */
    public function __construct(Array $user)
    {
    $this->data = $user;
    }

    /**
     * Get the message envelope.
     */
    

    /**
     * Get the message content definition.
     */
    /**
    *public function content(): Content
    *{
        *return new Content(
            *view: 'view.emails.mail',
        *);
    *}
    */
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build() {
        return $this->from('sender@test.com')
                    ->subject('Mon objet personnalisé')
                    ->view('emails.mail');
    }

}
