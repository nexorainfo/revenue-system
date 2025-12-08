<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceParticularResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $request_columns = $request->input('columns')['invoice_particulars'] ?? [];
        return [
            'परिमाण' => $this->when(in_array('quantity', $request_columns), $this->quantity ?? ''),
            'दर' => $this->when(in_array('rate', $request_columns), $this->rate ?? ''),
            'कैफियत' => $this->when(in_array('remarks', $request_columns), $this->remarks ?? ''),
            'बाकि' => $this->when(in_array('due', $request_columns), $this->due ?? ''),
        ];
    }
}
