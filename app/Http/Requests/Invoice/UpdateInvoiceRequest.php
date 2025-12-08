<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'=>['required','string','max:255'],
            'address'=>['required','string','max:255'],
            "payment_date" => ['required'],
            "payment_date_en" => ['required'],
            "fiscal_year_id" => ['required', 'exists:fiscal_years,id,deleted_at,NULL'],
            "payment_method" => ['required', 'in:Cash,Bank'],
            "reference_code" => ['required_if:payment_method,Bank'],
            "particulars" => ['required', 'array'],
            "particulars.*.revenue" => ['required', 'string'],
            "particulars.*.quantity" => ['required', 'integer', 'min:0'],
            "particulars.*.rate" => ['required', 'integer', 'min:0'],
            "particulars.*.due" => ['nullable', 'integer', 'min:0'],
            "particulars.*.remarks" => ['nullable'],
            "remarks" => ['nullable']
        ];
    }
}
