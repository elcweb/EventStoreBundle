<?php

namespace Elcweb\EventStoreBundle\EventListener;

use Doctrine\ORM\EntityManager;
use JMS\Serializer\Serializer;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Security\Core\SecurityContext;

use Elcweb\EventStoreBundle\Entity\Event;

class Store extends BaseEventListener
{
    protected $em;

    public function __construct(Logger $logger, Serializer $serializer, SecurityContext $security, EntityManager $em)
    {
        parent::__construct($logger, $serializer, $security);
        $this->em = $em;
    }

    public function onEvent(GenericEvent $event)
    {
        $data = $this->serializer->serialize($event->getArguments(), 'json');

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
        $elem->setSubject($event->getSubject());

        $this->em->persist($elem);
        $this->em->flush();
    }
}
