<?php

namespace App\Http\Requests\Admin\Poll;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePollRequest extends FormRequest
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
            'title' => 'sometimes|string|max:255',
            'start_at' => 'sometimes|date',
            'end_at' => 'sometimes|date|after:start_at',
            'options' => ['nullable', 'array'],
            'options.*.id' => ['nullable', 'exists:poll_options,id'],
            'options.*.text' => ['sometimes', 'string', 'max:255'],
            'new_options' => ['nullable', 'array'],
            'new_options.*' => ['sometimes', 'string', 'max:255'],

        ];
    }
}
