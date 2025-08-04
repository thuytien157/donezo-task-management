<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Invite extends Mailable
{
    use Queueable, SerializesModels;


    public $link;
    public $title;
    /**
     * Create a new message instance.
     */
    public function __construct($link, $title)
    {
        $this->link = $link;
        $this->title = $title;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Lời mời',
        );
    }


    public function build()
    {
        return $this->subject('Lời mời')
            ->view('emails.inviteMember')
            ->with(['link' => $this->link, 'title' => $this->title]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
