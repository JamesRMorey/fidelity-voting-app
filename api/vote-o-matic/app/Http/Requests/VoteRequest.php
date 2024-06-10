<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class VoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'question_option_id' => ['required', 'numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            'question_option_id.required' => 'Please select an option to vote on',
            'question_option_id.numeric' => 'The option you selected is invalid',
        ];
    }
}
