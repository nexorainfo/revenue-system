<?php

namespace App\Http\Requests\Revenue;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRevenueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'revenue_category_id' => ['required', Rule::exists('revenue_categories', 'id')->withoutTrashed()],
            'code_no' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'amount' => ['required', 'numeric'],
            'remarks' => ['nullable', 'string'],
        ];
    }
}
