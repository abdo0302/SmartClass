<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class WelcomEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $data;


    /**
     * Create a new message instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }//end __construct()


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('abdelljabarhamri06@gmail.com', 'DR Abdelljabar Hamri'),
            subject: 'Bienvenue à SmartClass'
        );
    }//end envelope()


    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'Maile.WelcomEmail',
            with: ['data' => $this->data]
        );
    }//end content()


    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }//end attachments()


}//end class
