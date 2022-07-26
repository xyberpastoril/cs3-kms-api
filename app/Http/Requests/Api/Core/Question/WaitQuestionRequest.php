<?php

namespace App\Http\Requests\Api\Core\Question;

use Illuminate\Foundation\Http\FormRequest;

class WaitQuestionRequest extends FormRequest
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

    public function withValidator($validator)
    {
        /**
         * TODO: Alert user if the email is already
         * added to the waitlist for the specific
         * question.
         */
    }
}
