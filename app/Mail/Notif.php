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
    public $user;
    /**
     * Create a new message instance.
     */
    public function __construct($evaluation, $utilisateur)
    {
        $this->eval = $evaluation;
        $this->user = $utilisateur;
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
        return $this
        ->with(['libelle_eval' => $this->eval->libelle, 'prenom' => $this->user->prenom, 'nom' => $this->user->nom])
        ->view('emails.notif_note')
        ->cc('nicolas.leymat@etu.iut-tlse3.fr');
    }

}
