<?php

namespace App\Http\Requests\RevenueCategory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRevenueCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'revenue_category_id' => ['nullable', Rule::exists('revenue_categories', 'id')->withoutTrashed()],
        ];
    }
}
