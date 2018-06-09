<?php require 'index/index.php'; ?>

<html>
<head>
  <link href="/style.css" rel="stylesheet" type="text/css"/>
  <title>Notifier</title>
</head>
<body>
<div class="container">
  <h1>notification status</h1>
    <?php $res = json_decode($notification_storage->getNotificationStatus()); ?>
  <p class="time">
    Last sent at
    <span> UTC <?php echo $res->time; ?> </span>
    (<?php echo $res->time_difference; ?> hours ago)
  </p>
    <?php foreach ($res->sending_statuses as $status) {?>
      <p class="sender"> <?php echo $status->name;?>
        <span class="status"> -
          <?php if ($status->status == 1) { ?>
            sent
          <?php } else if ($status->status == -1) {?>
            not sent, no money
          <?php } else {?>
            not sent
          <?php }?>
        </span>
      </p>
    <?php }?>
  <div class="button">
    <a href="/?request=send">Send notification</a>
  </div>
</div>
</body>
</html>