<?php
namespace neovav\Events;

/**
 * Interface for subsribers
 *
 * @author neovav <neovav@@outlook.com>
 * @date 2019.08.17 09:20
 * @version 0.0.2
 */

interface ISubscriber
{
    /**
     * Get event name
     *
     * @return string
     */
    public function getEventName() :string;

    /**
     * Check type event is set
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
     * Get order notice
     *
     * @return string
     */
    public function getOrderNotice() :string;

    /**
     * Get callable function
     *
     * @return callable
     */
    public function getUpdate() :callable;
}