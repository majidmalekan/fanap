<?php

namespace App\Http\Requests\Admin\Poll;

use Illuminate\Foundation\Http\FormRequest;

class StorePollRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'start_at' => 'required|date|after_or_equal:today',
            'end_at' => 'required|date|after:start_at',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:255'

        ];
    }
}
