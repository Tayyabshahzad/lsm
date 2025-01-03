<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class RegistrationConfirmationMail extends Mailable implements ShouldQueue
{
    
    

    use Queueable, SerializesModels;
    public $user;
    public $term;
    public $trialClassResponse;
    public $course;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,$term,$trialClassResponse,$course)
    {
        $this->user = $user;
        $this->term = $term;
        $this->trialClassResponse = $trialClassResponse;
        $this->course = $course;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: "Get Ready! Your Trial Class for ".$this->course->title." is Schedule",
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.registration_confirmation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
