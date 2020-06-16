<?php


namespace App\Providers;


use App\Repositories\Contract\LotteryRepository;
use App\Repositories\Contract\LotterySessionRepository;
use App\Repositories\Contract\ProductRepository;
use App\Repositories\Contract\UserRepository;
use App\Repositories\Eloquent\LotteryRepositoryEloquent;
use App\Repositories\Eloquent\LotterySessionRepositoryEloquent;
use App\Repositories\Eloquent\ProductRepositoryEloquent;
use App\Repositories\Eloquent\UserRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider  extends ServiceProvider
{
    public array $singletons = [
        UserRepository::class => UserRepositoryEloquent::class,
        ProductRepository::class => ProductRepositoryEloquent::class,
        LotteryRepository::class => LotteryRepositoryEloquent::class,
        LotterySessionRepository::class => LotterySessionRepositoryEloquent::class,
    ];
}
