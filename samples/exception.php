<?php
use \neovav\Events\Subscriber;
use \neovav\Events\Notifier;
use \neovav\Events\INotice;

if (!DEFINED('FILELOG')) DEFINE('FILELOG', time().'.err');

$func = function (INotice $notice) {
    $f = fopen(FILELOG, 'a');
    $txt = "\r\n".date('H:i:s').' EXP    => '.$notice->getEventName();
    if ($notice instanceof Exception)
        $txt .=
            "\r\n".get_class($notice) . '( CODE => ' . $notice->getCode() . ', LINE => '.$notice->getLine().') : ' .
            "\r\n              ". $notice->getMessage();

    fwrite($f,$txt);
    fclose($f);
};

try {
    $subscr_exp = new Subscriber('*', $func, Notifier::TYPE_EXCEPT, Notifier::ORD_FIRST);
    Notifier::attach($subscr_exp);
} catch(Exception $e) {var_dump($e);};