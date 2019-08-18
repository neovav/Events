<?php
use \neovav\Events\Subscriber;
use \neovav\Events\Notifier;
use \neovav\Events\INotice;

$func = function (INotice $notice) {
    echo "\r\n", 'DEBUG          => ', $notice->getEventName();
    if ($notice->isEventData()) var_dump($notice->getEventData());
};

try {
    $subscr_dbg = new Subscriber('DEBUG@Start', $func);
    Notifier::attach($subscr_dbg);
} catch(Exception $e) {var_dump($e);};