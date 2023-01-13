<?php

namespace App\Http\Requests\Url;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => ['required'],
            'link' => ['required'],
            'slug' => ['nullable', 'unique:urls,slug,NULL,id,deleted_at,NULL', 'max:15']
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'user_id' => __('auth.labels.user_id'),
            'name' => __('auth.labels.name'),
            'link' => __('auth.labels.link'),
            'slug' => __('auth.labels.slug'),
        ];
    }
}
