<?php
namespace neovav\Events;

/**
 * The notifier class that generates notice for subscribers
 *
 * @author neovav <neovav@@outlook.com>
 * @date 2019.08.17 07:50
 * @version 0.0.1
 */

class Notifier
{

    /** @var string         Notifier class author           */
    const AUTH      = 'NeoVAV';

    /** @var string         Number version                  */
    const VERSION   = '0.0.1';

    /** @var int                Sending a notification first to the queue   */
    const ORD_NOT_SET   = 0;

    /** @var int                Sending a notification first to the queue   */
    const ORD_FIRST     = 1;

    /** @var int                Sending a notification last to the queue   */
    const ORD_LAST      = 2;

    /** @var int                All avents*/
    const EVN_ALL       = 0;

    /** @var int                Subscribers to events type*/
    const EVN_GRP       = 1;

    /** @var array      Subscribers list   */
    private static $list = [
        self::EVN_GRP => [],
        self::EVN_ALL => []
    ];

    /**
     * Attache subscriber for event
     *
     * @param ISubscriber ...$subscribers
     *
     * @return void
     */
    public static function attach (ISubscriber ...$subscribers)
     {

         foreach ($subscribers as $subscriber) {

             $name = $subscriber->getEventName();
             $type = $subscriber->getEventType();
             $order = $subscriber->getOrderNotice();

             if ($subscriber->isEventType()) {
                 $list = &self::$list[self::EVN_GRP];
                 $key = $type;
             } else {
                 $list = &self::$list[self::EVN_ALL];
                 $key = $name;
             };

             if (empty($list)) $list[$key] = [];
             if (empty($list[$key][$order])) $list[$key][$order] = [];

             $list[$key][$order][] = $subscriber->getUpdate();
         };
     }

    /**
     * Detach subscriber for event
     *
     * @param ISubscriber ...$subscribers
     *
     * @return void
     */
    public static function detach (ISubscriber ...$subscribers)
     {
         foreach ($subscribers as $subscriber) {

             $name = $subscriber->getEventName();
             $type = $subscriber->getEventType();
             $order = $subscriber->getOrderNotice();

             if ($subscriber->isEventType()) {
                 $list = &self::$list[self::EVN_GRP];
                 $key = $type;
             } else {
                 $list = &self::$list[self::EVN_ALL];
                 $key = $name;
             };

             if (!empty($list[$key]) && !empty($list[$key][$order])) {
                 $data = array_keys($list[$key][$order]);
                 $n = count($data);
                 $update = $subscriber->getUpdate();
                 for ($i = 0; $i < $n; $i++) {
                     $k = $data[$i];
                     if ($list[$key][$order][$k] == $update) {
                         $list[$key][$order][$k] = null;
                         unset($list[$key][$order][$k]);
                         if (empty($list[$key][$order])) {
                             $list[$key][$order] = null;
                             unset($list[$key][$order]);

                             if (empty($list[$key])) {
                                 $list[$key] = null;
                                 unset($list[$key]);
                             };
                         };
                         break;
                     };
                 };
             };
         };
     }

    /**
     * Attache subscriber for event
     *
     * @param INotice $notice
     *
     * @return void
     */
    public static function notify (INotice $notice)
     {
         if ($notice->isEventType()) {
             $type = $notice->getEventType();
             for($t = 0; $t < 2; $t++) {
                 if (!empty(self::$list[$t][$type])) {
                     if (!empty(self::$list[$t][$type][self::ORD_FIRST])) {
                         $keys = array_keys(self::$list[$t][$type][self::ORD_FIRST]);
                         $n = count($keys);
                         for ($i = 0; $i < $n; $i++) {
                             $k = $keys[$i];
                             $update = self::$list[$t][$type][self::ORD_FIRST][$k];

                             if (is_callable($update)) $update($notice);
                         };
                     };

                     if (!empty(self::$list[$t][$type][self::ORD_NOT_SET])) {
                         $keys = array_keys(self::$list[$t][$type][self::ORD_NOT_SET]);
                         $n = count($keys);
                         for ($i = 0; $i < $n; $i++) {
                             $k = $keys[$i];
                             $update = self::$list[$t][$type][self::ORD_NOT_SET][$k];

                             if (is_callable($update)) $update($notice);
                         };
                     };

                     if (!empty(self::$list[$t][$type][self::ORD_LAST])) {
                         $keys = array_keys(self::$list[$t][$type][self::ORD_NOT_SET]);
                         $n = count($keys) - 1;
                         for ($i = $n; $i > 0; $i++) {
                             $k = $keys[$i];
                             $update = self::$list[$t][$type][self::ORD_NOT_SET][$k];

                             if (is_callable($update)) $update($notice);
                         };
                     };
                 };
             };
         };
     }
}