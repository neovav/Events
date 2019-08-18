<?php
use \neovav\Events\Notifier;
use \neovav\Events\Notice;
use \neovav\Events\IEventData;
use neovav\Events\Subscriber;

require_once '..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

include_once 'log.php';
include_once 'debug.php';
include_once 'exception.php';

$notice_log = new Notice(__FILE__, 'start', Notifier::TYPE_LOGS);
$notice_dbg = new Notice(__FILE__,'DEBUG@Start');
Notifier::notify($notice_dbg);
Notifier::notify($notice_log);

Notifier::detach($subscr_dbg);

class FException extends Exception implements IEventData {};

$func_exp = function (Notice $notice) {
    if ($notice instanceof Exception) throw $notice;
};

try {
    $subscr = new Subscriber( '*', $func_exp, Notifier::TYPE_EXCEPT, Notifier::ORD_LAST);
    Notifier::attach($subscr);
} catch(Exception $e) {};

$exp = new FException('This is exception', 1);
$notice_exp = new Notice(__FILE__,'start', Notifier::TYPE_EXCEPT, $exp);
Notifier::notify($notice_exp);