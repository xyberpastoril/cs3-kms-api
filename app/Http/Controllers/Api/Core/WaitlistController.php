<?php

namespace App\Http\Controllers\Api\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Core\Waitlister\DestroyWaitlisterRequest;
use App\Http\Requests\Api\Core\Waitlister\StoreWaitlisterRequest;
use App\Mail\Api\Core\Waitlister\AddedToWaitlist;
use App\Models\Core\Question;
use App\Models\Core\Waitlister;
use Illuminate\Support\Facades\Mail;

// use Illuminate\Http\Request;

class WaitlistController extends Controller
{
    /**
     * This function adds a certain user to the waitlist for the answer
     * of the specific question.
     * 
     * This can only be done when the question does not have any
     * answered questions.
     * 
     * * TESTED
     */
    public function store(StoreWaitlisterRequest $request)
    {
        // TODO: Move question inside the request class
        // TODO: Check form request class.
        $input = $request->safe()->only('email');
        $route = $request->only('question');

        $waitlister = Waitlister::create([
            'email' => $input['email'],
            'question_id' => $route['question']->id,
        ]);

        Mail::to($input['email'])->queue(new AddedToWaitlist($waitlister, $route['question']));

        return response()->json([
            'message' => 'Successfully added your email to this question\'s waitlist. You will be notified when the answer is available.',
            'question' => $route['question'],
            'waitlister' => $waitlister,
        ]);
    }

    /**
     * This function removes a certain user from the waitlist for the answer
     * of the specific question.
     * 
     * The user can opt to be removed from the waitlist even if the question
     * already has answers (for privacy purposes).
     * 
     * * TESTED
     */
    public function destroy(DestroyWaitlisterRequest $request)
    {
        $route = $request->only('waitlister', 'question');

        $route['waitlister']->delete();

        return response()->json([
            'message' => 'Successfully removed your email from this question\'s waitlist.' . ($route['question']->answer_count == 0 ? ' You will not be notified when the answer is available.' : ''),
            'question' => $route['question'],
            'waitlister' => $route['waitlister'],
        ]);
    }
}
