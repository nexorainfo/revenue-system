<?php

namespace App\Traits;

use App\Events\ActivityLogEvent;

trait EventObserveTrait
{
    public static function booted()
    {
        $class = get_called_class();
        static::created(function ($model) {
            event(new ActivityLogEvent('Create', get_called_class(), $model->id));
        });
        static::updated(function ($model) {
            event(new ActivityLogEvent('Edit', get_called_class(), $model->id));
        });
        static::deleted(function ($model) {
            event(new ActivityLogEvent('Delete', get_called_class(), $model->id));
        });
        static::restored(function ($model) {
            event(new ActivityLogEvent('Restore', get_called_class(), $model->id));
        });
        static::forceDeleted(function ($model) {
            event(new ActivityLogEvent('Force Delete', get_called_class(), $model->id));
        });
    }
}
