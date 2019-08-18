<?php
namespace neovav\Events;

/**
 * Interface to notice for subscribers
 *
 * @author neovav <neovav@@outlook.com>
 * @date 2019.08.17 09:20
 * @version 0.0.1
 */

interface INotice
{
    public function getSender();

    public function getEventName() :string;

    public function isEventType() :bool;

    public function getEventType() :string;

    public function getEventDate() :IEventData;
}