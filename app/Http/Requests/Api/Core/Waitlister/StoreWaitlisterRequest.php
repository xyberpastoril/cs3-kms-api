<?php

namespace App\Http\Requests\Api\Core\Waitlister;

use App\Models\Core\Answer;
use App\Models\Core\Question;
use App\Models\Core\Waitlister;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class StoreWaitlisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->question->answer_count == 0;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    protected function prepareForValidation()
    {
        $question = Question::select('questions.id', 'answers.count as answer_count')
            ->where('uuid', $this->route('question'))
            ->leftJoinSub(
                Answer::select('question_id', DB::raw('count(*) as count'))
                    ->groupBy('question_id'),
                'answers', 'answers.question_id', 'questions.id'
            )
            ->firstOrFail();

        $this->merge([
            'question' => $question,
        ]);
    }

    public function withValidator($validator)
    {
        /**
         * Alert user if the email is already
         * added to the waitlist for the specific
         * question.
         */
        $validator->after(function ($validator) {
            $isAlreadyWaitlister = Waitlister::where('email', $this->email)
                ->where('question_id', $this->question->id)
                ->count();

            if ($isAlreadyWaitlister) {
                $validator->errors()->add('email', 'You are already on the waitlist for this question.');
            }
        });
    }
}
