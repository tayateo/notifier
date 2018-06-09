<?php

namespace Notifier;

/**
 * Class NotificationStorage
 * @package Notifier
 */
class NotificationStorage
{
    /**
     * @var \PDO
     */
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * @return int
     */
    public function getLastTimestamp(): int
    {
        $last_sent = $this->db
            ->query('SELECT timestamp FROM notifications WHERE status = 1 ORDER BY timestamp DESC LIMIT 1')
            ->fetchColumn();

        return (int) $last_sent;
    }

    public function getNotificationStatus(): string
    {
        $last_timestamp = $this->getLastTimestamp();
        $status = $this->db->prepare('SELECT name, status FROM notifications WHERE timestamp = ?');
        $status->execute([$last_timestamp]);
        $sending_statuses = $status->fetchAll(\PDO::FETCH_ASSOC);

        return json_encode([
            "time" => date('H:i:s d M Y', $last_timestamp),
            "sending_statuses" => $sending_statuses,
            "time_difference" => $this->timeDifference($last_timestamp)]);
    }

    private function timeDifference(int $timestamp): int
    {
        $stored_date = new \DateTime();
        $stored_date->setTimestamp($timestamp);
        $current_date = new \DateTime(null, new \DateTimeZone('UTC'));
        $diff = $current_date->diff($stored_date);
        return $diff->h + ($diff->days*24);
    }

    /**
     * @param int $timestamp
     * @param string $name
     * @param int $status
     */
    public function addNewStatus(int $timestamp, string $name, int $status): void
    {
        $this->db
            ->prepare('INSERT INTO notifications(timestamp, name, status) VALUES (?,?,?);')
            ->execute([$timestamp, $name, $status]);
    }
}