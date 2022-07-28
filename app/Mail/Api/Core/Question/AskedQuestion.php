<?php

namespace App\Mail\Api\Core\Question;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AskedQuestion extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $question;
    private $waitlister;

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
        return $this->subject("You just asked a question: {$this->question->content}")
            ->markdown('mail.core.question.asked', [
                'question' => $this->question,
                'waitlister' => $this->waitlister,
            ]);
    }
}
