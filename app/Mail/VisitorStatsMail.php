<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VisitorStatsMail extends Mailable
{
    use Queueable, SerializesModels;
    public $stats;

    /**
     * Create a new message instance.
     */
    public function __construct($stats)
    {
        $this->stats = $stats;
    }

     /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Statistiques des Visiteurs')
                    ->view('visitor_stats'); // On utilise une vue pour l'email
    }
}
