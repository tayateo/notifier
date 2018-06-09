<?php

namespace Notifier\Senders;
use Notifier\Interfaces\NotificationSender;

/**
 * Class TelegramSender
 * @package Notifier\Senders
 */
class TelegramSender implements NotificationSender
{
    /**
     * @var string
     */
    private $chat_id;

    /**
     * @var string
     */
    private $bot_token;

    /**
     * @var string
     */
    private $message;

    public function __construct(string $chat_id, string $bot_token, string $message)
    {
        $this->chat_id = $chat_id;
        $this->bot_token = $bot_token;
        $this->message = $message;
    }

    public function send(): int
    {
        $response = file_get_contents("https://api.telegram.org/$this->bot_token/sendMessage?chat_id=$this->chat_id&text=$this->message");
        return $response ? 1 : 0;
    }
}