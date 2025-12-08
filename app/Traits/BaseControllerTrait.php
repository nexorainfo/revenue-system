<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Module;

trait BaseControllerTrait
{
    public function constructionMethod(): void
    {
        view()->share('officeSetting', \officeSetting());
    }

    /**
     * @param $permission
     * @return void
     */
    public function checkAuthorization($permission): void
    {
        abort_if(
            Gate::denies($permission),
            403,
            'You are not allowed to access this resource'
        );
    }

    public function deleteFile($file_url): void
    {
        if (Storage::disk('public')->exists($file_url)) {
            Storage::disk('public')->delete($file_url);
        }
    }

    public function forgotCache(string $cacheName): void
    {
        Cache::forget($cacheName);
    }

    public function checkModuleExistence(string $moduleName): bool
    {
        return !collect(Module::allEnabled())->keys()->contains($moduleName);
    }
}
