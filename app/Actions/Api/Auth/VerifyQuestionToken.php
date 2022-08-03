<?php

namespace App\Actions\Api\Auth;

use App\Models\Core\Question;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\Concerns\AsAction;

class VerifyQuestionToken
{
    use AsAction;

    public function handle($question, $update_token)
    {
        if (!$question) {
            return false;
        }
        if(!Hash::check($update_token, $question->update_token)) {
            return false;
        }
        return true;
    }
}
