<?php

namespace App\Http\Requests\OfficeSetting;

use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOfficeSettingRequest extends FormRequest
{
    final public function authorize(): bool
    {
        return Gate::allows('officeSetting_edit');
    }


    final public function rules(): array
    {
        return [
            'province_id' => ['nullable', Rule::exists('provinces', 'id')->withoutTrashed()],
            'district_id' => ['nullable', Rule::exists('districts', 'id')->withoutTrashed()],
            'local_body_id' => ['nullable', Rule::exists('local_bodies', 'id')->withoutTrashed()],
            'fiscal_year_id' => ['nullable', Rule::exists('fiscal_years', 'id')->withoutTrashed()],
            'ward_no' => ['nullable'],
        ];
    }
}
