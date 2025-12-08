<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleMiddleware
{
    final public function handle(Request $request, Closure $next): Response
    {
        if (! empty($request->user()->role)) {
            if (Cache::has($this->getCacheKey())) {
                $permissions = Cache::get($this->getCacheKey());
            } else {
                $permissions = Cache::remember($this->getCacheKey(), 12 * 60 * 60, function () use ($request) {
                    return $request->user()->role->permissions->pluck('title');
                });
            }

            collect($permissions)->each(function ($title) {
                Gate::define($title, function () {
                    return true;
                });
            });
        }

        return $next($request);
    }

    final public function getCacheKey(): string
    {
        return md5('permissions-'.auth()->id());
    }
}
