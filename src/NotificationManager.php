<?php

namespace Notifier;
use Notifier\Interfaces\NotificationSender;

/**
 * Class NotificationManager
 * @package Notifier
 */
class NotificationManager
{
    /**
     * @var NotificationStorage
     */
    private $notification_storage;

    /**
     * @var int
     */
    private $sending_interval;

    public function __construct(NotificationStorage $notification_storage, int $sending_interval)
    {
        $this->notification_storage = $notification_storage;
        $this->sending_interval = $sending_interval;
    }

    /**
     * @param NotificationSender[] $senders
     * @return void
     */
    public function sendNotification(array $senders): void
    {
        if($this->notificationIntervalPassed()) {
            $timestamp = new \DateTime(null, new \DateTimeZone('UTC'));

            foreach($senders as $name => $sender)
            {
                $this->notification_storage->addNewStatus($timestamp->getTimestamp(), $name, $sender->send());
            }
        }
    }

    public function notificationIntervalPassed(): bool
    {
        $current_time = new \DateTime(null, new \DateTimeZone('UTC'));
        $time_passed = ($current_time->getTimestamp() - $this->notification_storage->getLastTimestamp());
        return $time_passed > $this->sending_interval;
    }
}