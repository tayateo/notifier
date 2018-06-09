<?php

use Notifier\Senders\{EmailSender, SmsSender, TelegramSender};

$email_sender = new EmailSender(
    new Swift_SmtpTransport('host', 25),
    ['to@example.com' => 'Receiver'],
    ['from@example.com' => 'Notifier'],
    'Notification Alert',
    'You have a new notification alert!');

// for bytehand you should use "+" before number
$sms_sender = new SmsSender(
    '+0000000',
    'id',
    'key',
    'Notification Alert',
    5);

$telegram_sender = new TelegramSender(
    'chat_id',
    'bot_token',
    'Notification Alert'
);

return [
    'email' => $email_sender,
    'sms' => $sms_sender,
    'telegram' => $telegram_sender];