<?php

require_once __DIR__.'/../vendor/autoload.php';
require __DIR__.'/config.php';
require __DIR__.'/db_connection.php';
require __DIR__.'/auth.php';

use Notifier\{NotificationManager, NotificationStorage};

$db_file = getenv('DATABASE_FILE');

if (file_exists($db_file)) {
    $db = establish_connection($db_file);
} else {
    new SQLite3($db_file);
    $db = establish_connection($db_file);
    create_tables($db);
}

$notification_storage = new NotificationStorage($db);
$notification_manager = new NotificationManager($notification_storage, 3600);

$senders = include(__DIR__.'/config.php');

if (isset($_GET['request']) && $_GET['request'] == 'send') {
    $notification_manager->sendNotification($senders);
}