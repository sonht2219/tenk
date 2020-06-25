<?php

namespace App\Providers;

use App\Service\Contract\AuthService;
use App\Service\Contract\DtoBuilderService;
use App\Service\Contract\FeedbackService;
use App\Service\Contract\FileService;
use App\Service\Contract\LotteryRewardService;
use App\Service\Contract\LotteryService;
use App\Service\Contract\LotterySessionService;
use App\Service\Contract\ProductService;
use App\Service\Contract\UserAddressService;
use App\Service\Contract\UserService;
use App\Service\Impl\AuthServiceImpl;
use App\Service\Impl\DtoBuilderServiceImpl;
use App\Service\Impl\FeedBackServiceImpl;
use App\Service\Impl\FileServiceImpl;
use App\Service\Impl\LotteryRewardServiceImpl;
use App\Service\Impl\LotteryServiceImpl;
use App\Service\Impl\LotterySessionServiceImpl;
use App\Service\Impl\ProductServiceImpl;
use App\Service\Impl\UserAddressServiceImpl;
use App\Service\Impl\UserServiceImpl;
use App\Services\Contract\RegionService;
use App\Services\Impl\RegionServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        AuthService::class => AuthServiceImpl::class,
        ProductService::class => ProductServiceImpl::class,
        LotteryService::class => LotteryServiceImpl::class,
        DtoBuilderService::class => DtoBuilderServiceImpl::class,
        LotterySessionService::class => LotterySessionServiceImpl::class,
        LotteryRewardService::class => LotteryRewardServiceImpl::class,
        FeedbackService::class => FeedBackServiceImpl::class,
        RegionService::class => RegionServiceImpl::class,
        UserAddressService::class => UserAddressServiceImpl::class,
        FileService::class => FileServiceImpl::class,
        UserService::class => UserServiceImpl::class,
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
