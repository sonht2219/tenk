<?php

namespace App\Providers;

use App\Service\Contract\AuthService;
use App\Service\Impl\AuthServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        AuthService::class => AuthServiceImpl::class
    ];
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
        if(config('app.https'))
        {
            \URL::forceScheme('https');
        }
    }
}
