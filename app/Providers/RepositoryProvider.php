<?php


namespace App\Providers;


use App\Repositories\Contract\ArticleRepository;
use App\Repositories\Contract\BannerRepository;
use App\Repositories\Contract\BannerTypeRepository;
use App\Repositories\Contract\DistrictRepository;
use App\Repositories\Contract\FeedbackRepository;
use App\Repositories\Contract\LotteryRepository;
use App\Repositories\Contract\LotteryRewardInfoRepository;
use App\Repositories\Contract\LotteryRewardRepository;
use App\Repositories\Contract\LotterySessionRepository;
use App\Repositories\Contract\ProductRepository;
use App\Repositories\Contract\ProvinceRepository;
use App\Repositories\Contract\UserAddressRepository;
use App\Repositories\Contract\UserRepository;
use App\Repositories\Contract\WalletLogRepository;
use App\Repositories\Contract\WalletRepository;
use App\Repositories\Eloquent\ArticleRepositoryEloquent;
use App\Repositories\Eloquent\BannerRepositoryEloquent;
use App\Repositories\Eloquent\BannerTypeRepositoryEloquent;
use App\Repositories\Eloquent\DistrictRepositoryEloquent;
use App\Repositories\Eloquent\FeedbackRepositoryEloquent;
use App\Repositories\Eloquent\LotteryRepositoryEloquent;
use App\Repositories\Eloquent\LotteryRewardInfoRepositoryEloquent;
use App\Repositories\Eloquent\LotteryRewardRepositoryEloquent;
use App\Repositories\Eloquent\LotterySessionRepositoryEloquent;
use App\Repositories\Eloquent\ProductRepositoryEloquent;
use App\Repositories\Eloquent\ProvinceRepositoryEloquent;
use App\Repositories\Eloquent\UserAddressRepositoryEloquent;
use App\Repositories\Eloquent\UserRepositoryEloquent;
use App\Repositories\Eloquent\WalletLogRepositoryEloquent;
use App\Repositories\Eloquent\WalletRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider  extends ServiceProvider
{
    public array $singletons = [
        UserRepository::class => UserRepositoryEloquent::class,
        ProductRepository::class => ProductRepositoryEloquent::class,
        LotteryRepository::class => LotteryRepositoryEloquent::class,
        LotterySessionRepository::class => LotterySessionRepositoryEloquent::class,
        WalletLogRepository::class => WalletLogRepositoryEloquent::class,
        WalletRepository::class => WalletRepositoryEloquent::class,
        LotteryRewardRepository::class => LotteryRewardRepositoryEloquent::class,
        FeedbackRepository::class => FeedbackRepositoryEloquent::class,
        DistrictRepository::class => DistrictRepositoryEloquent::class,
        ProvinceRepository::class => ProvinceRepositoryEloquent::class,
        UserAddressRepository::class => UserAddressRepositoryEloquent::class,
        LotteryRewardInfoRepository::class => LotteryRewardInfoRepositoryEloquent::class,
        ArticleRepository::class => ArticleRepositoryEloquent::class,
        BannerRepository::class => BannerRepositoryEloquent::class,
        BannerTypeRepository::class => BannerTypeRepositoryEloquent::class,
    ];
}
