<?php

namespace App\Http\Controllers\Api\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Core\Answer\StoreAnswerRequest;
use App\Http\Requests\Api\Core\Answer\UpdateAnswerRequest;
use App\Models\Core\Answer;
// use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * TODO: This function stores an answer to a specific question.
     * 
     * It can only be done by admins.
     * 
     * @return JsonResponse
     */
    public function store(StoreAnswerRequest $request)
    {

    }

    /**
     * TODO: This function updates an answer to a specific question.
     * 
     * It can only be done by admins.
     * 
     * @return JsonResponse
     */
    public function update(Answer $answer, UpdateAnswerRequest $request)
    {

    }

    /**
     * TODO: This function destroys an answer to a specific question.
     * 
     * It can only be done by admins.
     * 
     * @return JsonResponse
     */
    public function destroy(Answer $answer)
    {

    }
}
