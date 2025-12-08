<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ActivityEventListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        if (!app()->runningInConsole() && \Auth::check() && \Auth::user() instanceof \App\Models\User) {
            ActivityLog::create([
                'model_type' => $event->model ?? null,
                'model_id' => $event->model_id ?? null,
                'activity_type' => $event->activity_type,
                'user_id' => auth()->id(),
                'ip' => request()->ip(),
                'agent' => request()->userAgent(),
            ]);
        }
    }
}
