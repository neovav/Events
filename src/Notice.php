<?php
namespace neovav\Events;

/**
 * Notice for subscribers
 *
 * @author neovav <neovav@@outlook.com>
 * @date 2019.08.17 08:20
 * @version 0.0.2
 */

class Notice implements INotice
{
    /** @var string         Notifier class author           */
    const AUTH      = 'NeoVAV';

    /** @var string         Number version                  */
    const VERSION   = '0.0.2';

    private $sender;
    private $name;
    private $type;
    private $data;

    /**
     * Class constructor Notice
     *
     * @param mixed $sender
     * @param string $name
     * @param string $type
     * @param IEventData $data
     */
    public function __construct($sender, string $name, string $type = null, IEventData $data = null)
    {
        $this->sender = $sender;
        $this->name = $name;
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Get sender object
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Get event name
     *
     * @return string
     */
    public function getEventName() :string
    {
        return $this->name;
    }

    /**
     * Check event type
     *
     * @return bool
     */
    public function isEventType() :bool
    {
        return !is_null($this->type);
    }

    /**
     * Get event type
     *
     * @return string
     */
    public function getEventType() :string
    {
        return $this->type;
    }

    /**
     * Check event data
     *
     * @return bool
     */
    public function isEventData() :bool
    {
        return $this->data instanceof IEventData;
    }

    /**
     * Get event data
     *
     * @return IEventData
     */
    public function getEventData() :IEventData
    {
        return $this->data;
    }
}