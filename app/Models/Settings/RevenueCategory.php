<?php

namespace App\Models\Settings;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\EventObserveTrait;

class RevenueCategory extends Model
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
