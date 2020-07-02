<?php


namespace App\Queue\Listeners;


use App\Queue\Events\LotterySessionEnded;
use App\Repositories\Contract\LotteryRepository;
use HoangDo\Notification\Enum\NotificationType;
use HoangDo\Notification\Model\Notification;
use HoangDo\Notification\Service\NotifyService;
use Illuminate\Contracts\Queue\ShouldQueue;

class PushNotifyWhenSessionEnded implements ShouldQueue
{
    private NotifyService $notifyService;
    private LotteryRepository $lotteryRepo;

    public function __construct(NotifyService $notifyService, LotteryRepository $lotteryRepo)
    {
        $this->notifyService = $notifyService;
        $this->lotteryRepo = $lotteryRepo;
    }

    public function handle(LotterySessionEnded $event) {
        $reward = $event->reward;
        $product = $reward->session->product;
        $lottery = $reward->lottery;

        //push user trúng thưởng
        $notification_reward = new Notification();
        $notification_reward->title = 'TENK';
        $notification_reward->description = 'Chúc mừng, bạn đã trúng thưởng đợt mở thưởng '
            . $reward->session_id.
            '. Sản phẩm trúng thưởng ' . $product->name;
        $notification_reward->content = $reward->session_id;
        $notification_reward->type = NotificationType::SESSION;
        $this->notifyService->storeNotifications([$reward->user_id], $notification_reward);

        //push đến các user đã tham gia khác
        $joined_users = $this->lotteryRepo
            ->findUsersJoinedSession($reward->session_id)
            ->pluck('user_id')
            ->filter(fn($id) => $id != $reward->user_id)
            ->toArray();
        $notification = new Notification();
        $notification->title = 'TENK';
        $notification->description = 'Đợt mở thưởng ' . $reward->session_id .
            ' của sản phẩm ' . $product->name .
            ' đã kết thúc. Mã trúng thưởng là: ' . $lottery->serial;
        $notification->content = $reward->session_id;
        $notification->type = NotificationType::SESSION;
        $this->notifyService->storeNotifications($joined_users, $notification);
    }
}
