<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class Notif extends Mailable
{
    use Queueable, SerializesModels;

    public $eval;
    /**
     * Create a new message instance.
     */
    public function __construct($evaluation)
    {
        $this->eval = $evaluation;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $nomMatiere = $this->eval->ressource->libelle;

        return new Envelope(
            subject: "Nouvelle Note en $nomMatiere",
        );
    }

    /**
     * Get the message content definition.
     */
    /**public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }*/

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        $nomEval = $this->eval->libelle;
        $destinataire = Config::get('mail.to.address');

        return $this
        ->with(['contenu' => "Une nouvelle note a été ajoutée en $nomEval"])
        ->view('emails.notif_note');
    }

}
