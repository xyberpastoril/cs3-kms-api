<?php

namespace App\Actions\Api\Auth;

use App\Models\Core\Question;
use Lorisleiva\Actions\Concerns\AsAction;

class VerifyQuestionToken
{
    use AsAction;

    public function handle($question, $update_token)
    {
        if (!$question) {
            return false;
        }
        if ($question->update_token != $update_token) {
            return false;
        }
        return true;
    }
}
