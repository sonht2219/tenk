<?php

namespace App\Providers;

use App\Service\Contract\AuthService;
use App\Service\Contract\DtoBuilderService;
use App\Service\Contract\LotteryService;
use App\Service\Contract\LotterySessionService;
use App\Service\Contract\ProductService;
use App\Service\Impl\AuthServiceImpl;
use App\Service\Impl\DtoBuilderServiceImpl;
use App\Service\Impl\LotteryServiceImpl;
use App\Service\Impl\LotterySessionServiceImpl;
use App\Service\Impl\ProductServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        AuthService::class => AuthServiceImpl::class,
        ProductService::class => ProductServiceImpl::class,
        LotteryService::class => LotteryServiceImpl::class,
        DtoBuilderService::class => DtoBuilderServiceImpl::class,
        LotterySessionService::class => LotterySessionServiceImpl::class
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
