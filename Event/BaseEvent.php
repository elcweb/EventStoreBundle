<?php
namespace Elcweb\EventStoreBundle\Event;

use Symfony\Component\EventDispatcher\GenericEvent;

class BaseEvent extends GenericEvent
{
    protected $data;

    // data2 is for backward compatibility
    public function __construct($data, $data2 = false)
    {
        $this->data = ($data2) ? $data2 : $data;
        $subject    = ($data2) ? $data  : null;

        parent::__construct($subject, $this->data);
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
