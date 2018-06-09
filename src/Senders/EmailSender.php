<?php

namespace Notifier\Senders;
use Notifier\Interfaces\NotificationSender;

/**
 * Class EmailSender
 * @package Notifier\Senders
 */
class EmailSender implements NotificationSender
{
    /**
     * @var \Swift_SmtpTransport
     */
    private $mailEngine;

    /**
     * @var array
     */
    private $receivers;

    /**
     * @var array
     */
    private $sender;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $message;

    public function __construct(\Swift_SmtpTransport $mailEngine, array $receivers, array $sender, string $subject, string $message)
    {
        $this->receivers = $receivers;
        $this->mailEngine = $mailEngine;
        $this->sender = $sender;
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function send(): int
    {
        $message = (new \Swift_Message($this->subject))
            ->setFrom($this->sender)
            ->setTo($this->receivers)
            ->setBody($this->message, 'text/html', 'utf-8');

        try {
            return (int) $this->mailEngine->send($message);
        } catch (\Exception $e) {
            return 0;
        }
    }
}