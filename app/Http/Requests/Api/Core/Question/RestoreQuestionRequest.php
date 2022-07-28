<?php

namespace App\Http\Requests\Api\Core\Question;

use App\Models\Core\Question;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RestoreQuestionRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $question = Question::where('uuid', $this->route('question'))
            ->withTrashed()
            ->firstOrFail();
        $this->merge(['question' => $question]);
    }
}
