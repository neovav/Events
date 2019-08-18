<?php
namespace neovav\Events;

/**
 * Interface to notice for subscribers
 *
 * @author neovav <neovav@@outlook.com>
 * @date 2019.08.17 09:20
 * @version 0.0.2
 */

interface INotice
{

    /**
     * Get sender object
     */
    public function getSender();

    /**
     * Get event name
     *
     * @return string
     */
    public function getEventName() :string;

    /**
     * Check event type
     *
     * @return bool
     */
    public function isEventType() :bool;

    /**
     * Get event type
     *
     * @return string
     */
    public function getEventType() :string;

    /**
     * Check event data
     *
     * @return bool
     */
    public function isEventData() :bool;

    /**
     * Get event data
     *
     * @return IEventData
     */
    public function getEventData() :IEventData;
}