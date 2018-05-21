<?php

use Burgeramt\PushoverHelper;

require __DIR__ . '/../vendor/autoload.php';

$pushover = new PushoverHelper();
$pushover->sendPushoverNotification('TEST');

