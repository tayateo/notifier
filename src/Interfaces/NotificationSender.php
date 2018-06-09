<?php

namespace Notifier\Interfaces;


interface NotificationSender
{
    public function send(): int;
}