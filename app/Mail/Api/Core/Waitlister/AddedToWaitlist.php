<?php

namespace App\Mail\Api\Core\Waitlister;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AddedToWaitlist extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $waitlister;
    private $question;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($waitlister, $question)
    {
        $this->waitlister = $waitlister;
        $this->question = $question;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("You are added to a question's waitlist: {$this->question->content}")
            ->markdown('mail.core.waitlist.added', [
                'waitlister' => $this->waitlister,
                'question' => $this->question,
            ]);
    }
}
