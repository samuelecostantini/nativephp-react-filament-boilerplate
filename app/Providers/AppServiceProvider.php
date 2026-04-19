<?php

namespace App\Providers;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Model::unguard();

        if (! (bool) config('nativephp-internal.running')) {
            return;
        }

        if (! Schema::hasTable('migrations')) {
            Artisan::call('migrate', ['--force' => true]);
        }

        if (Schema::hasTable('brands') && ! Brand::query()->exists()) {
            Artisan::call('db:seed', ['--force' => true]);
        }
    }
}
