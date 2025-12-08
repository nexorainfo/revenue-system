<?php

namespace App\Http\Requests\UserManagement\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

final class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('user_edit');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->withoutTrashed()->ignore($this->user)],
            'phone' => ['nullable',  Rule::unique('users', 'phone')->withoutTrashed()->ignore($this->user)],
            'role_id' => ['required', Rule::exists('roles', 'id')->withoutTrashed()],
            'ward_no' => ['nullable'],
            'designation' => ['nullable','string','max:255'],
        ];
    }
}
