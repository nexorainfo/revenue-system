<?php

namespace App\Models;

use App\Models\Settings\FiscalYear;
use App\Models\User;
use App\Traits\GetAllColumns;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\EventObserveTrait;

final class Invoice extends Model
{
    use SoftDeletes;
    use EventObserveTrait;
    use GetAllColumns;


    protected $fillable = [
        'invoice_no',
        'fiscal_year_id',
        'user_id',
        'name',
        'address',
        'payment_method',
        'reference_code',
        'payment_date',
        'payment_date_en',
        'remarks',
        'invoice_copy',
    ];


    public function fiscalYear(): BelongsTo
    {
        return $this->belongsTo(FiscalYear::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function InvoiceParticulars(): HasMany
    {
        return $this->hasMany(InvoiceParticular::class);
    }
}
