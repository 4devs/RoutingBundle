<?php

namespace FDevs\RoutingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $supportedDrivers = ['mongodb'];

        $treeBuilder->root('f_devs_routing')
            ->children()
            ->scalarNode('db_driver')
                ->validate()
                    ->ifNotInArray($supportedDrivers)
                    ->thenInvalid('The driver %s is not supported. Please choose one of ' . json_encode($supportedDrivers))
                ->end()
                ->cannotBeOverwritten()
                ->defaultValue('mongodb')
                ->cannotBeEmpty()
            ->end()
            ->scalarNode('manager_name')->defaultNull()->end()
            ->arrayNode('dynamic')
                ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('persistence')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->arrayNode('mongodb')
                                ->addDefaultsIfNotSet()
                                ->canBeEnabled()
                                ->children()
                                    ->scalarNode('manager_name')->defaultNull()->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end()
        ;

        return $treeBuilder;
    }
}
