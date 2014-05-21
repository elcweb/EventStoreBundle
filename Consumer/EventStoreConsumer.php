<?php

namespace Elcweb\EventStoreBundle\Consumer;

use Doctrine\ORM\EntityManager;
use JMS\Serializer\Serializer;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Elcweb\EventStoreBundle\Entity\Event;

class EventStoreConsumer implements ConsumerInterface
{
    private $em, $serializer;

    public function __construct(EntityManager $em, Serializer $serializer)
    {
        $this->em         = $em;
        $this->serializer = $serializer;
    }

    public function execute(AMQPMessage $msg)
    {
        $routingKey = $msg->get('routing_key');

        echo ("Event: ".$routingKey.PHP_EOL);

        try {
            $data = $this->serializer->deserialize($msg->body, 'array', 'json');

            $elem = new Event();
            $elem->setName($routingKey);
            $elem->setClassname('');
            $elem->setData($msg->body);
            $elem->setUsername($data['username']);

            $this->em->persist($elem);
            $this->em->flush();

            return true;
        } catch (\Exception $e) {
            return false;
        }        
    }
}
