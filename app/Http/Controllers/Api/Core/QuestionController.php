<?php

namespace App\Http\Controllers\Api\Core;

use App\Actions\Api\Auth\VerifyQuestionToken;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Core\Question\DestroyQuestionRequest;
use App\Http\Requests\Api\Core\Question\RestoreQuestionRequest;
use App\Http\Requests\Api\Core\Question\SearchQuestionRequest;
use App\Http\Requests\Api\Core\Question\ShowQuestionRequest;
use App\Http\Requests\Api\Core\Question\StoreQuestionRequest;
use App\Http\Requests\Api\Core\Question\UpdateQuestionRequest;
use App\Mail\Api\Core\Question\AskedQuestion;
use App\Mail\Api\Core\Question\NewQuestion;
use App\Models\Core\Question;
use App\Models\Core\Waitlister;
use App\Models\User;
use App\Services\Api\Core\Question\SearchQuestionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

// use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * This function serves the search results based on the query string.
     * Additional filters may be included such as the category, and tags.
     * 
     * As a user, answered questions will be ranked first.
     * As an admin, unanswered questions will be ranked first.
     */
    public function search(SearchQuestionRequest $request, SearchQuestionService $service)
    {
        $input = $request->safe()->only('query');
        
        if(isset($input['query'])) {
            $service->addKeywords($input['query']);
        }
        $service->order();
        
        // TODO: Add category filter
        // TODO: Add tags filter

        return response()->json($service->getResults());
    }

    /**
     * This function shows the questions' content and may include
     * answers if there are any.
     * 
     * If the token parameter exists, check if the token is legitimate.
     * It will determine if the user is allowed to update or destroy
     * the question. 
     * 
     * If the token is legitimate, return true to $canUpdate,
     * otherwise false. 
     * 
     * If the token does not exist, $canUpdate will be 
     * automatically false.
     */
    public function show(ShowQuestionRequest $request)
    {
        $route = $request->only('question', 'update_token');

        /**
         * Determine if the user is allowed to update or destroy the question.
         * 
         * If there's no answer, the owner of the question and the admins can update or destroy it.
         * Otherwise, only the admin can update or destroy it.
         */
        $isOwner = VerifyQuestionToken::run($route['question'], $route['update_token']);
        $canUpdate = Auth::guard('api')->check() || ($isOwner && !count($route['question']->answers));

        // Call relationships
        $route['question']->load('answers', 'tags', 'category');

        return response()->json([
            'question' => $route['question'],
            'canUpdate' => $canUpdate,
            'isOwner' => $isOwner,
        ]);
    }

    /**
     * This function stores a question from an outside user. 
     * It only requires an email and the question. 
     * 
     * Next, it generates a token and sends an email as acknowledgement 
     * that the user created a question to the app and will be informed 
     * when there is a new answer.
     * 
     * Then, it will be stored to the database.
     * 
     * Lastly, an email will be sent as acknowledgement to the question
     * owner. Admins will also be notified that there's a new question.
     */
    public function store(StoreQuestionRequest $request)
    {
        $input = $request->safe()->only('content', 'email');

        // TODO: Include question tags and category.

        $update_token = Str::uuid();
        $question = Question::create([
            'content' => $input['content'],
            'update_token' => Hash::make($update_token),
        ]);

        $waitlister = new Waitlister([
            'email' => $input['email'],
            'question_id' => $question->id,
        ]);
        $question->waitlisters()->save($waitlister);
        
        //? Shall I refactor this part downwards or include above ones?
        // TODO: Include naked update token in the email.

        Mail::to($input['email'])->queue(new AskedQuestion($waitlister, $question));

        // TODO: Send emails only those who opted.
        // ? PREREQUISITE: Account Settings > Notifications > New Question
        $users = User::all();        
        foreach($users as $user) {
            Mail::to($user->email)->queue(new NewQuestion($question, $user));
        }

        return response()->json([
            'message' => 'Question created successfully.',
            'question' => $question,
            'update_token' => $update_token, // TODO: Remove this later.
        ]);
    }

    /**
     * This function updates a question. However, this can only be done
     * when there is still no answer from the admins.
     * 
     * It requires an update token from the question owner to edit the
     * question content.
     * 
     * However, admins can revise this question to make it more readable.
     * They can also revise the category/tags as the admins see fit.
     */
    public function update(UpdateQuestionRequest $request)
    {
        $input = $request->safe()->only('content');
        $route = $request->only('question');

        // TODO: Update the question tags and category if they are changed.

        $route['question']->content = $input['content'];
        $route['question']->save();

        return response()->json([
            'message' => 'Question updated successfully.',
            'question' => $route['question'],
        ]);
    }

    /**
     * This function destroys the question, but only if there's no answer.
     * 
     * It can only be done by admins (in case it sounds
     * inappropriate) or the question owner.
     * 
     * When done by the admins, it will be soft-deleted.
     * Otherwise, force delete.
     */
    public function destroy(DestroyQuestionRequest $request)
    {
        $route = $request->only('question', 'update_token');
        
        /**
         * Determine if the question will be force deleted or not.
         */
        if(Auth::guard('api')->check() && !$route['update_token']) {
            $route['question']->delete();
        } else {
            // TODO: Look after the deletion of the questions' relationships.
            // $question->waitlisters()->delete();
            // $question->answers()->delete();
            $route['question']->forceDelete();
        }

        return response()->json([
            'message' => 'Question deleted successfully.',
            'question' => $route['question'],
        ]);
    }

    /**
     * This function restores the soft deleted question.
     * 
     * It can only be done by admins (in case it was accidentally deleted).
     */
    public function restore(RestoreQuestionRequest $request)
    {
        $route = $request->only('question');

        $route['question']->restore();

        return response()->json([
            'message' => 'Question restored successfully.',
            'question' => $route['question'],
        ]);
    }
}
