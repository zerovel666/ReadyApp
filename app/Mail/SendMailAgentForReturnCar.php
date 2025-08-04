<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMailAgentForReturnCar extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public string $deadlineTime;
    public string $longitude_a;
    public string $latitude_a;
    public string $longitude_b;
    public string $latitude_b;

    public function __construct(
        string $deadlineTime,
        string $longitude_a,
        string $latitude_a,
        string $longitude_b,
        string $latitude_b
    ) {
        $this->deadlineTime = $deadlineTime;
        $this->longitude_a = $longitude_a;
        $this->latitude_a = $latitude_a;
        $this->longitude_b = $longitude_b;
        $this->latitude_b = $latitude_b;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Return car',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.send-mail-agent-for-return-car',
            with: [
                "deadlineTime" => $this->deadlineTime,
                "longitude_a" => $this->longitude_a,
                "latitude_a" => $this->latitude_a,
                "longitude_b" => $this->longitude_b,
                "latitude_b" => $this->latitude_b,
            ],
        );
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
