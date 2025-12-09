<?php

namespace App\Models\Settings;

use App\Models\InvoiceParticular;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\EventObserveTrait;

final class RevenueCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    use EventObserveTrait;


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'title',
        'revenue_category_id',
        'user_id',
    ];

    public function revenueCategory(): BelongsTo
    {
        return $this->belongsTo(RevenueCategory::class);
    }

    public function revenueCategories(): HasMany
    {
        return $this->hasMany(RevenueCategory::class, 'revenue_category_id')->with('revenueCategories');
    }

    public function revenues(): HasMany
    {
        return $this->hasMany(Revenue::class);
    }

    public function invoiceParticulars(): RevenueCategory|HasManyThrough
    {
        return $this->hasManyThrough(InvoiceParticular::class, Revenue::class);
    }
    public function nestedRevenueCategories(): HasMany
    {
        return $this->hasMany(RevenueCategory::class, 'revenue_category_id')->with('revenueCategories','invoiceParticulars');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
