<?php
namespace Elcweb\EventStoreBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Elcweb\EventStoreBundle\Event\BaseEvent;
use Symfony\Bridge\Monolog\Logger;

class Log extends BaseEventListener
{
    public function onEvent(BaseEvent $event)
    {
        $token = $this->security->getToken();
        if ($token) {
            $user = $token->getUser()->getUsername();
        } else {
            $user = "cli";
        }
        $this->logger->info("Event: [" . $user . "] " . $event->getName());
    }
}
