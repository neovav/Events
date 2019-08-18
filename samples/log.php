<?php
use \neovav\Events\Subscriber;
use \neovav\Events\Notifier;
use \neovav\Events\INotice;

if (!DEFINED('FILELOG')) DEFINE('FILELOG', time().'.log');

$func = function (INotice $notice) {
    $f = fopen(FILELOG, 'a');
    $txt = "\r\n".date('H:i:s').' LOG    => '.$notice->getEventName();
    fwrite($f,$txt);
    fclose($f);
};

try {
    $subscr_log = new Subscriber('*', $func, Notifier::TYPE_LOGS);
    Notifier::attach($subscr_log);
} catch(Exception $e) {var_dump($e);};