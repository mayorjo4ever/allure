<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentStatusMail extends Mailable
{
    use Queueable, SerializesModels;
    public $appointment;
    public $status;

    /**
     * Create a new message instance.
     */
    public function __construct($appointment, $status)
    {
        $this->appointment = $appointment;
        $this->status = $status; // 'approved' or 'canceled'
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Appointment Status Mail',
        );
    }
    
    public function build()
    {
        return $this->subject('Your Appointment has been ' . ucfirst($this->status))
                    ->markdown('emails.appointment.status');
    }
    
    
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.appointment.status',
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
