<?php

namespace App\Models;

use App\Traits\QueryFilterTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class ActivityLog extends Model
{
    use SoftDeletes;
    use QueryFilterTrait;


    protected $fillable = [
        'model_type',
        'model_id',
        'activity_type',
        'user_id',
        'ip',
        'agent',
        'performed_action_on',
        'is_seen',
    ];

    public function scopeFilter(Builder $query, array|string $param = []): Builder
    {
        $this->filterByUserRole($query, $param);

        return $query;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
