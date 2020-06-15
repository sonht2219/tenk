<?php

namespace App\Providers;

use App\Service\Contract\AuthService;
use App\Service\Contract\DtoBuilderService;
use App\Service\Impl\AuthServiceImpl;
use App\Service\Impl\DtoBuilderServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        AuthService::class => AuthServiceImpl::class,
        DtoBuilderService::class => DtoBuilderServiceImpl::class
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
