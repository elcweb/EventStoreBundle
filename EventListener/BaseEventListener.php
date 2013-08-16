<?php
namespace Elcweb\EventStoreBundle\EventListener;

use Doctrine\ORM\EntityManager;
use JMS\Serializer\Serializer;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\Security\Core\SecurityContext;

class BaseEventListener
{
    protected $logger;
    protected $serializer;
    protected $em;
    protected $security;

    public function __construct(Logger $logger, Serializer $serializer, EntityManager $em, SecurityContext $security)
    {
        $this->logger     = $logger;
        $this->serializer = $serializer;
        $this->em         = $em;
        $this->security   = $security;
    }

    public function onEvent($event)
    {

    }
}
