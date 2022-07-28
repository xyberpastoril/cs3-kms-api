<?php

namespace App\Http\Requests\Api\Core\Question;

use App\Actions\Api\Auth\VerifyQuestionToken;
use App\Models\Core\Question;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DestroyQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /**
         * If admin, check if bearer token is valid.
         * 
         * Otherwise, check if the update token is provided. 
         * If provided, see to it that it is valid. 
         * If invalid for the current question, then false.
         */
        return Auth::guard('api')->check() || VerifyQuestionToken::run($this->question, $this->route('update_token'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
        ];
    }

    protected function prepareForValidation()
    {
        $question = Question::where('uuid', $this->route('question'))
            ->firstOrFail();

        $this->merge([
            'question' => $question,
            'update_token' => $this->route('update_token'),
        ]);
    }

    public function withValidator($validator)
    {
        /**
         * If the answer already exists for this question and the one
         * who initiated this request is the question owner, return an error.
         */
        $validator->after(function ($validator) {
            $this->question->load('answers');

            if(count($this->question->answers) && !Auth::guard('api')->check()) {
                $validator->errors()->add('content', 'You can no longer delete this question because it already has an answer.');
            }
        });
    }
}
