<?php

namespace App\Providers;

use App\Queue\Events\DepositCashPhoneCardCallbacked;
use App\Queue\Events\LotterySessionEnded;
use App\Queue\Events\LotterySessionSaved;
use App\Queue\Events\LotterySessionStartCountDown;
use App\Queue\Events\ProductSaved;
use App\Queue\Listeners\PushNotifyResultDepositCashPhoneCard;
use App\Queue\Listeners\PushNotifyWhenSessionEnded;
use App\Queue\Listeners\PushNotifyWhenSessionStartCountDown;
use App\Queue\Listeners\StartSessionForProduct;
use App\Queue\Listeners\PrepareLotteryForSession;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ProductSaved::class => [
            StartSessionForProduct::class
        ],
        LotterySessionSaved::class => [
            PrepareLotteryForSession::class,
        ],
        LotterySessionStartCountDown::class => [
            PushNotifyWhenSessionStartCountDown::class
        ],
        LotterySessionEnded::class => [
            PushNotifyWhenSessionEnded::class
        ],
        DepositCashPhoneCardCallbacked::class => [
            PushNotifyResultDepositCashPhoneCard::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
