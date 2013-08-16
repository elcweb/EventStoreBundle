<?php

namespace Elcweb\EventStoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReplayEventsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('elcweb:eventstore:replay')
            ->setDescription('This will replay every event. Warning.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em         = $this->getContainer()->get('doctrine')->getEntityManager();
        $dispatcher = $this->getContainer()->get('event_dispatcher');

        $output->writeln("Get all Event");

        $events = $em->getRepository('ElcwebEventStoreBundle:Event')->findAll();

        foreach ($events as $event) {
            $output->writeln("<comment>" . $event->getName() . "</comment>");
            $output->writeln($event->getClassname());
            $class = $event->getClassname();
            $data  = $this->getContainer()->get('serializer')->deserialize($event->getData(), "array", 'json');

            $dispatcher->dispatch($event->getName(), new $class($data));
        }
    }
}
