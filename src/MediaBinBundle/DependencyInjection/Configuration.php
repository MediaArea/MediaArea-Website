<?php

namespace MediaBinBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('media_bin');

        $rootNode
            ->children()
                ->arrayNode('local')
                    ->children()
                        ->scalarNode('path')->end()
                    ->end()
                ->end()

                ->arrayNode('external')
                    ->children()
                        ->scalarNode('enabled')->end()
                        ->arrayNode('openstack')
                            ->children()
                                ->scalarNode('auth_url')->end()
                                ->scalarNode('region')->end()
                                ->scalarNode('container')->end()
                                ->scalarNode('username')->end()
                                ->scalarNode('password')->end()
                                ->scalarNode('tenant_id')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
