<?php

namespace App\Http\Requests\Api\Core\Answer;

use App\Models\Core\Question;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreAnswerRequest extends FormRequest
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
            'content' => ['required'],
        ];
    }

    public function prepareForValidation()
    {
        $question = Question::where('uuid', $this->route('question'))
            ->firstOrFail();

        $this->merge([
            'question' => $question,
        ]);
    }
}
