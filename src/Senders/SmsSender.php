<?php

namespace Notifier\Senders;
use Notifier\Interfaces\NotificationSender;

/**
 * Class SmsSender
 * @package Notifier\Senders
 */
class SmsSender implements NotificationSender
{
    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $message;

    /**
     * @var float
     */
    private $sms_cost;

    const BASE = 'http://api.bytehand.com/v1';

    public function __construct(string $phone, string $id, string $key, string $message, float $sms_cost)
    {
        $this->phone = urlencode($phone);
        $this->id = $id;
        $this->key = $key;
        $this->message = urlencode($message);
        $this->sms_cost = $sms_cost;
    }

    public function send(): int
    {
        if ($this->check_balance()) {
            $response = file_get_contents(
                sprintf("%s/send?id=%s&key=%s&to=%s&from=from-server&text=%s",
                    self::BASE,
                    $this->id,
                    $this->key,
                    $this->phone,
                    $this->message));
            return (int) !json_decode($response, true)['status']; /* code 0 stays for sent */
        } else {
            return -1; /* no money to send sms */
        }
    }

    public function check_balance(): bool
    {
        $balance = file_get_contents(
            sprintf('%s/balance?id=%s&key=%s',
                self::BASE,
                $this->id,
                $this->key));
        return ((float) json_decode($balance, true)['description']) > $this->sms_cost;
    }
}