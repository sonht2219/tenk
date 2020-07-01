<?php


namespace HoangDo\Notification\Service;


use HoangDo\Notification\Enum\OsOption;
use HoangDo\Notification\Exception\NotificationFailedException;
use HoangDo\Notification\Model\NotifyToken;
use HoangDo\Notification\Model\Notification;
use HoangDo\Notification\Request\NotificationRequest;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface NotifyService
{
    /**
     * @param $user_id
     * @param string $token
     * @param $os
     * @return NotifyToken
     */
    public function storeTokenForUser($user_id, $token, $os = OSOption::DEFAULT_OS);
//
    /**
     * @param NotificationRequest $data
     * @return Notification[]|array
     * @throws NotificationFailedException
     */
    public function createNotifiesAndPush($data);

    /**
     * @param Notification $notification
     * @return Notification
     */
    public function storeBasicOrLinkNotification(Notification $notification);
//

    /**
     * @param array $user_ids
     * @param array $data
     * @return Notification|null
     */
    function storeBasicOrLinkNotifications(array $user_ids, array $data);

    /**
     * @param Authenticatable $user
     * @param int $notification_id
     * @return Notification
     * @throws ModelNotFoundException
     */
    public function findOneAndReadNotification($user, $notification_id);

    public function listNotifications($limit, $user);
}
