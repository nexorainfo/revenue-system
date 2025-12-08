<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $request_columns = $request->input('columns')['invoices'] ?? [];
        return [
            'बिल नं.' => $this->when(in_array('invoice_no', $request_columns), $this->invoice_no ?? ''),
            'आर्थिक वर्ष' => $this->when(in_array('fiscal_year_id', $request_columns), $this->fiscalYear->title ?? ''),
            'नाम' => $this->when(in_array('name', $request_columns), $this->name ?? ''),
            'ठेगाना' => $this->when(in_array('address', $request_columns), $this->address ?? ''),
            'भुक्तानी बिधि' => $this->when(in_array('payment_method', $request_columns), $this->payment_method ?? ''),
            'भुक्तानी मिति' => $this->when(in_array('payment_date', $request_columns), $this->payment_date ?? ''),
            'भुक्तानी मिति (ई.सं.)' => $this->when(in_array('payment_date_en', $request_columns), $this->payment_date_en->toDateString() ?? ''),
            'वडा' => $this->when(in_array('ward', $request_columns), $this->ward ?? ''),
            'Reference Code' => $this->when(in_array('reference_code', $request_columns), $this->reference_code ?? ''),
            'फारम' => InvoiceParticularResource::collection($this->whenLoaded('InvoiceParticulars'))
        ];
    }
}
