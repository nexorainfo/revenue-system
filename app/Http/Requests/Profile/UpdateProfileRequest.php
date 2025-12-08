<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:20'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->withoutTrashed()->ignore(auth()->user())],
            'phone' => ['required', Rule::unique('users', 'phone')->withoutTrashed()->ignore(auth()->user())],
            'profile_photo_path' => ['nullable', 'image'],
        ];
    }
}
