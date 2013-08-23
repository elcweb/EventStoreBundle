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

        // Log
        $container->setParameter('elcweb.listener.log.class', 'Elcweb\EventStoreBundle\EventListener\Log');
        $container->register('elcweb.listener.log', '%elcweb.listener.log.class%')
            ->addArgument(new Reference("logger"))
            ->addArgument(new Reference("serializer"))
            ->addArgument(new Reference("security.context"))
        ;

        // Store
        $container->setParameter('elcweb.listener.store.class', 'Elcweb\EventStoreBundle\EventListener\Store');
        $container->register('elcweb.listener.store', '%elcweb.listener.store.class%')
            ->addArgument(new Reference("logger"))
            ->addArgument(new Reference("serializer"))
            ->addArgument(new Reference("security.context"))
            ->addArgument(new Reference("doctrine.orm.default_entity_manager"))
        ;

        // Set dynamic event prefix to events
        foreach ($config['prefix'] as $prefix) {
            $container->getDefinition('elcweb.listener.log')->addTag('kernel.event_listener', array('event' => $prefix.'.#', 'method' => 'onEvent'));
            $container->getDefinition('elcweb.listener.store')->addTag('kernel.event_listener', array('event' => $prefix.'.#', 'method' => 'onEvent'));
        }
    }
}
