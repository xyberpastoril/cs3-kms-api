<?php

namespace App\Http\Requests\Api\Core\Answer;

use App\Models\Core\Answer;
use App\Models\Core\Question;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RestoreAnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('api')->check();
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

    public function prepareForValidation()
    {
        $question = Question::where('uuid', $this->route('question'))
            ->firstOrFail();

        $answer = Answer::where('uuid', $this->route('answer'))
            ->withTrashed()
            ->firstOrFail();

        $this->merge([
            'question' => $question,
            'answer' => $answer,
        ]);
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if($this->answer->question_id != $this->question->id) {
                $validator->errors()->add('question', 'Question must match the answer\'s source question.');
            }
        });
    }
}
