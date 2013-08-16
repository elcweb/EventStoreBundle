<?php
namespace Elcweb\EventStoreBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Elcweb\Bundle\EventStoreBundle\Entity\Event;

class Store extends BaseEventListener
{
    public function onEvent($event)
    {
        $data = $this->serializer->serialize($event->toArray(), 'json');

        $token = $this->security->getToken();
        if ($token) {
            $user = $token->getUser()->getUsername();
        } else {
            $user = "cli";
        }

        $elem = new Event();
        $elem->setName($event->getName());
        $elem->setClassname(get_class($event));
        $elem->setData($data);
        $elem->setUsername($user);

        $this->em->persist($elem);
        $this->em->flush();
    }
}
