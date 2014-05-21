<?php

namespace Elcweb\EventStoreBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ElcwebEventStoreExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        // RabbitMQ Store
        $container->setParameter('elcweb.consumer.store.class', 'Elcweb\EventStoreBundle\Consumer\EventStoreConsumer');
        $container->register('elcweb.eventstore.consumer.store', '%elcweb.consumer.store.class%')
            ->addArgument(new Reference("doctrine.orm.default_entity_manager"))
            ->addArgument(new Reference("serializer"))
        ;
    }
}
