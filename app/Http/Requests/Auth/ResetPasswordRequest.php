<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'token' => ['required'],
            'email' => ['required', 'email', 'exists:users'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()]
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'token' => __('auth.labels.token'),
            'email' => __('auth.labels.email'),
            'password' => __('auth.labels.password')
        ];
    }
}
