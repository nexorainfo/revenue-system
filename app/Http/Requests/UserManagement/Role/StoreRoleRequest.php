<?php

namespace App\Http\Requests\UserManagement\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', Rule::unique('roles', 'title')->withoutTrashed()],
            'permissions' => ['required', 'array'],
            'permissions.*' => [Rule::exists('permissions', 'id')],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'भूमिका शिर्षक अनिबार्य छ।',
            'title.unique' => 'भूमिका शीर्षक पहिले नै लिइएको छ।',
            'permissions.required' => 'अनुमति क्षेत्र आवश्यक छ।',
        ];
    }
}
