<?php


namespace App\Queue\Listeners;


use App\Models\PhoneCard;
use App\Queue\Events\DepositCashPhoneCardCallbacked;
use App\User;
use HoangDo\Notification\Enum\NotificationType;
use HoangDo\Notification\Model\Notification;
use HoangDo\Notification\Service\NotifyService;
use Illuminate\Contracts\Queue\ShouldQueue;

class PushNotifyResultDepositCashPhoneCard implements ShouldQueue
{
    private NotifyService $notifyService;

    public function __construct(NotifyService $notifyService)
    {
        $this->notifyService = $notifyService;
    }

    public function handle(DepositCashPhoneCardCallbacked $event) {
        /** @var PhoneCard $phone_card */
        $phone_card = $event->phone_card;
        /** @var User $user */
        $user = $event->user;

        $notification = new Notification();
        $notification->title = 'TENK';
        $notification->description = 'Nạp xu qua thẻ cào: ' . $phone_card->status;
        $notification->content = $notification->description;
        $notification->type = NotificationType::BASIC;
        $this->notifyService->storeNotifications([$user->id], $notification);
    }
}
