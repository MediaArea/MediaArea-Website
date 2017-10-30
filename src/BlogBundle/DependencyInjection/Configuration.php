<?php

namespace BlogBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('blog');

        $rootNode
            ->children()
                ->scalarNode('post_files_path')->end()
            ->end();

        return $treeBuilder;
    }
}
