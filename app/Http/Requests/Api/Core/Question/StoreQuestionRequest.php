<?php

namespace App\Http\Requests\Api\Core\Question;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
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
        // TODO: Include category and tags.

        return [
            'email' => ['sometimes', 'email'],
            'content' => ['required'],
        ];
    }
}
