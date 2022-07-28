<?php

namespace App\Mail\Api\Core\Question;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewQuestion extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $question;
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($question, $user)
    {
        $this->question = $question;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("New Question: {$this->question->content}")
            ->markdown('mail.core.question.new', [
                'question' => $this->question,
                'user' => $this->user,
            ]);
    }
}
