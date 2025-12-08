<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\EventObserveTrait;

class InvoiceParticular extends Model
{
    use HasFactory;
    use SoftDeletes;
    use EventObserveTrait;

    protected $fillable = [
        'invoice_id',
        'revenue_category_id',
        'revenue_id',
        'revenue',
        'quantity',
        'rate',
        'due',
        'fine',
        'remarks',
    ];

    protected $casts = [
        'quantity' => 'float',
        'rate' => 'float',
        'fine' => 'float',
        'due' => 'int'
    ];

    protected $appends = [
        'grand_total_amount',
        'amount_without_fine',
        'due_amount'
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function getGrandTotalAmountAttribute()
    {
        return $this->getAmountWithoutFineAttribute() + $this->getAmountWithoutFineAttribute() * $this->due + $this->fine;
    }

    public function getDueAmountAttribute(): float|int
    {
        return $this->getAmountWithoutFineAttribute() * $this->due;
    }

    public function getAmountWithoutFineAttribute(): float|int
    {
        return ($this->rate * $this->quantity);
    }
}
