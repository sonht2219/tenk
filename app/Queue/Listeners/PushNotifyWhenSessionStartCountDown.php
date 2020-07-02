<?php


namespace App\Queue\Listeners;


use App\Models\LotterySession;
use App\Queue\Events\LotterySessionStartCountDown;
use App\Repositories\Contract\LotteryRepository;
use HoangDo\Notification\Model\Notification;
use HoangDo\Notification\Service\NotifyService;
use HoangDo\Notification\Traits\CanPushNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class PushNotifyWhenSessionStartCountDown implements ShouldQueue
{
    private NotifyService $notifyService;
    private LotteryRepository $lotteryRepo;

    public function __construct(NotifyService $notifyService, LotteryRepository $lotteryRepo)
    {
        $this->notifyService = $notifyService;
        $this->lotteryRepo = $lotteryRepo;
    }

    public function handle(LotterySessionStartCountDown $event) {
        /** @var LotterySession $session */
        $session = $event->session;
        $product = $session->product;
        $user_ids = $this->lotteryRepo->findUsersJoinedSession($session->id)->pluck('user_id')->toArray();
        $notification = new Notification();
        $notification->title = 'Tenk';
        $notification->content = 'Sản phẩm '. $product->name . ' - Đợt ' . $session->id . ' bắt đầu mở thưởng.';
        $notification->description = 'Sản phẩm '. $product->name . ' - Đợt .' . $session->id . ' bắt đầu mở thưởng.';
        $this->notifyService->storeNotifications($user_ids, $notification);
    }
}
