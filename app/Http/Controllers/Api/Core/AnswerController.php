<?php

namespace App\Http\Controllers\Api\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Core\Answer\DestroyAnswerRequest;
use App\Http\Requests\Api\Core\Answer\RestoreAnswerRequest;
use App\Http\Requests\Api\Core\Answer\StoreAnswerRequest;
use App\Http\Requests\Api\Core\Answer\UpdateAnswerRequest;
use App\Models\Core\Answer;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * This function stores an answer to a specific question.
     * 
     * It can only be done by admins.
     * 
     * Updating an answer will be done using this function as
     * the latest answer will be emphasized in the frontend.
     * 
     * Moreover, past answers will be kept in the database for
     * reference by the admins.
     * 
     * * TESTED
     */
    public function store(StoreAnswerRequest $request)
    {
        $input = $request->safe()->only('content');
        $route = $request->only('question');

        $answer = new Answer([
            'content' => $input['content'],
            'user_id' => Auth::guard('api')->id(),
        ]);

        $route['question']->answers()->save($answer);

        // TODO: Send an email to users in the waitlist.

        return response()->json([
            'message' => 'Answer submitted successfully.',
            'answer' => $answer,
        ]);
    }

    /**
     * This function destroys an answer of a specific question.
     * 
     * It can only be done by admins.
     * 
     * * TESTED
     */
    public function destroy(DestroyAnswerRequest $request)
    {
        $route = $request->only('answer');

        $route['answer']->forceDelete();

        return response()->json([
            'message' => 'Answer deleted successfully.',
            'answer' => $route['answer'],
        ]);
    }
}
