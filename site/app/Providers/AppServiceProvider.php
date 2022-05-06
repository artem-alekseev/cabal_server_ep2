<?php

namespace App\Providers;

use App\Hashing\Md5Hasher;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Hash;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Hash::extend('md5', static function () {
            return new Md5Hasher();
        });
    }
}
