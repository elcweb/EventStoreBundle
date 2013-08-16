<?php
namespace Elcweb\EventStoreBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class BaseEvent extends Event
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}
