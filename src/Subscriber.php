<?php
namespace neovav\Events;

use \Exception;

/**
 * Class with subscriber data
 *
 * @author neovav <neovav@@outlook.com>
 * @date 2019.08.17 08:20
 * @version 0.0.2
 */

class Subscriber implements ISubscriber
{

    /** @var string         Notifier class author           */
    const AUTH      = 'NeoVAV';

    /** @var string         Number version                  */
    const VERSION   = '0.0.2';

    /** @var int            Unknow notice type*/
    const EX_ERROR_NOTICE_TYPE = 1;

    private static $list_ord = [Notifier::ORD_NOT_SET, Notifier::ORD_FIRST, Notifier::ORD_LAST];

    /** @var string             Event name */
    private $event;

    /** @var string             Event type */
    private $event_type;

    /** @var string             Position in queue    */
    private $order_apply;

    /** @var callable           Procedure for receiving notification    */
    private $update;

    /**
     * Class constructor Notifier
     *
     * @param string $event_name        Event name for subscribe
     * @param callable $update
     * @param string $event_type        Event type for subscribe
     * @param int $order_notice         Order for subscriber to the queue
     *
     * @throws \Exception
     */
    public function __construct(string $event_name, callable $update, string $event_type = null, int $order_notice = Notifier::ORD_NOT_SET)
    {
        if (!in_array($order_notice, self::$list_ord, true))
            throw new Exception('Unknow notice type', self::EX_ERROR_NOTICE_TYPE);

        $this->event = $event_name;
        $this->event_type = $event_type;
        $this->order_apply = $order_notice;
        $this->update = $update;
    }

    /**
     * Get event name
     *
     * @return string
     */
    public function getEventName() :string
    {
        return $this->event;
    }

    /**
     * Check type event is set
     *
     * @return bool
     */
    public function isEventType() :bool
    {
        return !is_null($this->event_type);
    }

    /**
     * Get event type
     *
     * @return string
     */
    public function getEventType() :string
    {
        return $this->event_type;
    }

    /**
     * Get order notice
     *
     * @return string
     */
    public function getOrderNotice() :string
    {
        return $this->order_apply;
    }

    /**
     * Get callable function
     *
     * @return callable
     */
    public function getUpdate() :callable
    {
        return $this->update;
    }
}