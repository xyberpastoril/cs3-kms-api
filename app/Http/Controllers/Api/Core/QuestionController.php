<?php

namespace App\Http\Controllers\Api\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Core\Question\SearchQuestionRequest;
use App\Http\Requests\Api\Core\Question\ShowQuestionRequest;
use App\Http\Requests\Api\Core\Question\StoreQuestionRequest;
use App\Http\Requests\Api\Core\Question\UpdateQuestionRequest;
use App\Http\Requests\Api\Core\Question\WaitQuestionRequest;
use App\Models\Core\Question;
// use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * TODO: This function serves the search results based on the query string.
     * Additional filters may be included such as the category, and tags.
     * 
     * As a user, answered questions will be ranked first.
     * As an admin, unanswered questions will be ranked first.
     * Create actions to decongest this function.
     * 
     * @return JsonResponse
     */
    public function search(SearchQuestionRequest $request)
    {

    }

    /**
     * TODO: This function shows the questions' content and may include
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
     * 
     * @return JsonResponse
     */
    public function show(Question $question, ShowQuestionRequest $request)
    {
        
    }

    /**
     * TODO: This function stores a question from an outside user. 
     * It only requires an email and the question. 
     * 
     * Then it generates a token and sends an email as acknowledgement 
     * that the user created a question to the app and will be informed 
     * when there is a new answer.
     * 
     * Lastly, it will be stored to the database.
     * 
     * TODO: Attempt to send an email using Queue instead of the usual
     * loading when it is processed by the server during the request.
     * 
     * @return JsonResponse
     */
    public function store(StoreQuestionRequest $request)
    {

    }

    /**
     * TODO: This function updates a question. However, this can only be done
     * when there is still no answer from the admins.
     * 
     * It requires an update token from the question owner to edit the
     * question content.
     * 
     * However, admins can revise this question to make it more readable.
     * They can also revise the category/tags as the admins see fit.
     * Moreover, the question owner will be informed by the change.
     * 
     * @return JsonResponse
     */
    public function update(Question $question, UpdateQuestionRequest $request)
    {
        return 'check';
    }

    /**
     * TODO: This function adds a certain user to the waitlist of the answer
     * of the specific question.
     * 
     * This can only be done when the question does not have any
     * answered questions.
     * 
     * @return JsonResponse
     */
    public function wait(Question $question, WaitQuestionRequest $request)
    {

    }

    /**
     * TODO: This function destroys the question, regardless if there's an
     * answer or not.
     * 
     * This function can only be done by admins (in case it sounds
     * inappropriate) or the question owner.
     * 
     * When done by the admins, it will be soft-deleted. A reason will
     * be required which will be sent to the question owner.
     * 
     * Otherwise, force delete and admins won't be informed by this.
     * 
     * @return JsonResponse
     */
    public function destroy(Question $question)
    {
        
    }
}
