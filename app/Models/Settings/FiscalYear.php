<?php

namespace App\Models\Settings;

use App\Models\Invoice;
use App\Traits\EventObserveTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class FiscalYear extends Model
{
    use SoftDeletes;
    use EventObserveTrait;



    protected $fillable = [
        'title',
    ];

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
