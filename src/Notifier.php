<?php
namespace neovav\Events;

/**
 * The notifier class that generates notice for subscribers
 *
 * @author neovav <neovav@@outlook.com>
 * @date 2019.08.17 07:50
 * @version 0.0.2
 */

class Notifier
{

    /** @var string         Notifier class author                           */
    const AUTH      = 'NeoVAV';

    /** @var string         Number version                                  */
    const VERSION   = '0.0.2';

    /** @var int                Sending a notification first to the queue   */
    const ORD_NOT_SET   = 0;

    /** @var int                Sending a notification first to the queue   */
    const ORD_FIRST     = 1;

    /** @var int                Sending a notification last to the queue   */
    const ORD_LAST      = 2;

    /** @var int                Subscribers to events type                  */
    const EVN_GRP       = 0;

    /** @var int                All avents                                  */
    const EVN_ALL       = 1;

    /** @var string             Type events for logs                        */
    const TYPE_LOGS     = 'logs';

    /** @var string             Type events for debugs                      */
    const TYPE_DEBUGS   = 'debugs';

    /** @var string             Type events for exceptions                  */
    const TYPE_EXCEPT   = 'exept';

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
             $order = $subscriber->getOrderNotice();

             if ($subscriber->isEventType()) {
                 $t = self::EVN_GRP;
                 $type = $subscriber->getEventType();
                 $key = $type;
             } else {
                 $t = self::EVN_ALL;
                 $key = $name;
             };

             if (empty(self::$list[$t])) self::$list[$t][$key] = [];
             if (empty(self::$list[$t][$key][$order])) self::$list[$t][$key][$order] = [];

             self::$list[$t][$key][$order][] = $subscriber->getUpdate();
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
             $order = $subscriber->getOrderNotice();

             if ($subscriber->isEventType()) {
                 $t = self::EVN_GRP;
                 $type = $subscriber->getEventType();
                 $key = $type;
             } else {
                 $t = self::EVN_ALL;
                 $key = $name;
             };

             if (!empty(self::$list[$t][$key]) && !empty(self::$list[$t][$key][$order])) {
                 $data = array_keys(self::$list[$t][$key][$order]);
                 $n = count($data);
                 $update = $subscriber->getUpdate();
                 for ($i = 0; $i < $n; $i++) {
                     $k = $data[$i];
                     if (self::$list[$t][$key][$order][$k] == $update) {
                         self::$list[$t][$key][$order][$k] = null;
                         unset(self::$list[$t][$key][$order][$k]);
                         if (empty(self::$list[$t][$key][$order])) {
                             self::$list[$t][$key][$order] = null;
                             unset(self::$list[$t][$key][$order]);

                             if (empty(self::$list[$t][$key])) {
                                 self::$list[$t][$key] = null;
                                 unset(self::$list[$t][$key]);
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
         for($t = 0; $t < 2; $t++) {
             if ($t == 0)
              {
                  if (!$notice->isEventType()) continue;
                  $name = $notice->getEventType();
              } else $name = $notice->getEventName();

             if (!empty(self::$list[$t][$name])) {
                 if (!empty(self::$list[$t][$name][self::ORD_FIRST])) {
                     $keys = array_keys(self::$list[$t][$name][self::ORD_FIRST]);
                     $n = count($keys);
                     for ($i = 0; $i < $n; $i++) {
                         $k = $keys[$i];
                         $update = self::$list[$t][$name][self::ORD_FIRST][$k];

                         if (is_callable($update)) $update($notice);
                     };
                 };

                 if (!empty(self::$list[$t][$name][self::ORD_NOT_SET])) {



                     $keys = array_keys(self::$list[$t][$name][self::ORD_NOT_SET]);
                     $n = count($keys);
                     for ($i = 0; $i < $n; $i++) {
                         $k = $keys[$i];
                         $update = self::$list[$t][$name][self::ORD_NOT_SET][$k];

                         if (is_callable($update)) $update($notice);
                     };
                 };

                 if (!empty(self::$list[$t][$name][self::ORD_LAST])) {
                     $keys = array_keys(self::$list[$t][$name][self::ORD_LAST]);
                     $n = count($keys) - 1;
                     for ($i = $n; $i > 0; $i++) {
                         $k = $keys[$i];
                         $update = self::$list[$t][$name][self::ORD_LAST][$k];

                         if (is_callable($update)) $update($notice);
                     };
                 };
             };
         };
     }
}