<?php

namespace App\Http\Requests\Api\Core\Waitlister;

use App\Models\Core\Answer;
use App\Models\Core\Question;
use App\Models\Core\Waitlister;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class DestroyWaitlisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
        $question = Question::select('questions.id', 'answers.count as answer_count')
            ->where('uuid', $this->route('question'))
            ->leftJoinSub(
                Answer::select('question_id', DB::raw('count(*) as count'))
                    ->groupBy('question_id'),
                'answers', 'answers.question_id', 'questions.id'
            )
            ->firstOrFail();

        $waitlister = Waitlister::where('uuid', $this->route('waitlister'))
            ->firstOrFail();

        $this->merge([
            'question' => $question,
            'waitlister' => $waitlister,
        ]);
    }
}
