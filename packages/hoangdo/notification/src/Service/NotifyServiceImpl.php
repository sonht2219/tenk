<?php


namespace HoangDo\Notification\Service;


use Carbon\Carbon;
use HoangDo\Notification\Enum\NotificationStatus;
use HoangDo\Notification\Enum\NotificationType;
use HoangDo\Notification\Enum\OsOption;
use HoangDo\Notification\Exception\NotificationFailedException;
use HoangDo\Notification\Model\Notification;
use HoangDo\Notification\Model\NotifyToken;
use HoangDo\Notification\Repository\NotificationRepository;
use HoangDo\Notification\Repository\NotifyTokenRepository;
use HoangDo\Notification\Traits\CanPushNotification;

class NotifyServiceImpl implements NotifyService
{
    use CanPushNotification;
    private NotifyTokenRepository $tokenRepo;
    private NotificationRepository $notificationRepo;

    public function __construct(
        NotifyTokenRepository $tokenRepo,
        NotificationRepository $notificationRepo
    )
    {
        $this->tokenRepo = $tokenRepo;
        $this->notificationRepo = $notificationRepo;
        $this->bootNotificationConfig();
    }

    public function storeTokenForUser($user_id, $token, $os = OSOption::DEFAULT_OS)
    {
        $os = $os ?? OsOption::DEFAULT_OS;
        if ($token) {
            $existed_tokens = $this->tokenRepo->findTokensByUserIdAndOrderByLastLog($user_id);
            $selected_token = null;
            foreach ($existed_tokens as $existed_token) {
                if ($existed_token->app_token == $token) {
                    $selected_token = $existed_token;
                    break;
                }
            }

            if (!$selected_token) {
                if (count($existed_tokens) >= config('notification.limit_each_user')) {
                    $selected_token = $existed_tokens[0];
                } else {
                    $selected_token = new NotifyToken();
                    $selected_token->user_id = $user_id;
                }
            }
            $selected_token->os = $os;
            $selected_token->app_token = $token;
            $selected_token->save();
            $selected_token->refresh();
            return $selected_token;
        }
        return null;
    }
//
//    public function storeNotificationByFields($user_id, $title, $description, $content, $type)
//    {
//        return $this->notify_repo->create(compact('user_id', 'title', 'description', 'content', 'type'));
//    }
//
//    public function storeProductNotification($user_id, $title, $description, $content)
//    {
//        return $this->storeNotificationByFields($user_id, $title, $description, $content, NotificationOptions::TYPE_PRODUCT);
//    }
//
//    public function storeLinkNotification($user_id, $title, $description, $content) {
//        return $this->storeNotificationByFields($user_id, $title, $description, $content, NotificationOptions::TYPE_LINK);
//    }
//
    /**
     * @inheritDoc
     */
    public function createNotifiesAndPush($data)
    {
        $policy_id = $data->policy_id;
        $req_user_ids = $data->user_ids;

        if (!$policy_id && (!$req_user_ids || count($req_user_ids) < 1))
            throw new NotificationFailedException('Yêu cầu chọn nhóm gửi hoặc cá nhân gửi');

        if ($policy_id == config('notification.for_all_notification_id')) {
            $notification = new Notification($data->filteredData());
            $notification->user_id = config('notification.for_all_notification_id');
            $notification = $this->storeBasicOrLinkNotification($notification);
            $this->pushNotification($notification);
            return $notification;
        }

//        $result = [];
        $user_ids = $req_user_ids;
//
//        if ($policy_id) {
//            $user_ids = [];
//            $raw_user_ids = $this->user_repo->findAllUserIdsByPolicy($policy_id);
//            foreach ($raw_user_ids as $user_id) $user_ids[] = $user_id->id;
//        }
//
        $chunked_user_ids = array_chunk($user_ids, 100);
        $notification_data = $data->filteredData();
        $notification = null;
        foreach ($chunked_user_ids as $chunked_user_id) {
            $notification = $this->storeBasicOrLinkNotifications($chunked_user_id, $notification_data);
            if (!$notification) {
                throw new NotificationFailedException(__('Không thể lưu notification'));
            }
            $this->pushNotification($notification);
        }
        return $notification;
    }
//
    public function storeBasicOrLinkNotification(Notification $notification)
    {
        $notification->type = filter_var($notification->content, FILTER_VALIDATE_URL)
            ? NotificationType::LINK
            : NotificationType::BASIC;
        return $this->notificationRepo->save($notification);
    }

    public function storeBasicOrLinkNotifications(array $user_ids, array $data)
    {
        $created_at = $updated_at = Carbon::now();
        $type = filter_var($data['content'], FILTER_VALIDATE_URL)
            ? NotificationType::LINK
            : NotificationType::BASIC;
        $result = new Notification($data);
        $fillable_data = $result->getAttributes();
        $insert_data = collect($user_ids)->map(fn($user_id) => [
            ...$fillable_data,
            ...compact('user_id', 'created_at', 'updated_at', 'type')
        ])->toArray();
        $inserted = $this->notificationRepo->insertMany($insert_data);
        return $inserted
            ? $result->setAttribute('type', $type)
            : null;
    }

    public function findOneAndReadNotification($user, $notification_id)
    {
        /** @var Notification $notification */
        $notification = $this->notificationRepo->find($notification_id);
        if (in_array($notification->user_id, [$user->id, config('notification.for_all_notification_id')])) {
            $notification->status = NotificationStatus::READ;
            $this->notificationRepo->save($notification);
        }
        return $notification;
    }

    public function listNotifications($limit, $user)
    {
        return $this->notificationRepo->listNotifiesOfUser($limit, $user->id);
    }
}
