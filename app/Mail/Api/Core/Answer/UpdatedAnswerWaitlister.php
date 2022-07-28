<?php

namespace App\Mail\Api\Core\Answer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpdatedAnswerWaitlister extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $waitlister;
    private $question;
    private $answer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($waitlister, $question, $answer)
    {
        $this->waitlister = $waitlister;
        $this->question = $question;
        $this->answer = $answer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Answer Updated: {$this->question->content}")
            ->markdown('mail.core.answer.updated-waitlister', [
                'waitlister' => $this->waitlister,
                'question' => $this->question,
                'answer' => $this->answer,
            ]);
    }
}
