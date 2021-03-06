<?php

namespace MediaConchOnlineBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('media_conch_online');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        $rootNode
            ->children()
                ->arrayNode('mediaconch')
                    ->children()
                        ->scalarNode('host')->end()
                        ->integerNode('port')->end()
                        ->scalarNode('api_version')->end()
                    ->end()
                ->end() // mediaconch
                ->arrayNode('absolute_url_for_mail')
                    ->info('Force url info for absolute url in email')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('host')->defaultValue(null)->end()
                        ->scalarNode('scheme')->defaultValue(null)->end()
                        ->scalarNode('baseUrl')->defaultValue(null)->end()
                    ->end()
                ->end() // absolute_url_for_mail
                ->arrayNode('api')
                    ->info('MediaConch API settings')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('baseUrl')->defaultValue(null)->end()
                        ->scalarNode('token')->defaultValue(null)->end()
                    ->end()
                ->end() // api
                ->arrayNode('quotas')
                    ->info('User quotas')
                    ->treatTrueLike(['enabled' => true])
                    ->treatFalseLike(['enabled' => false])
                    ->treatNullLike(['enabled' => false])
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')->defaultFalse()->end()
                        ->arrayNode('default')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('policies')->defaultValue(0)->end()
                                ->scalarNode('uploads')->defaultValue(0)->end()
                                ->scalarNode('urls')->defaultValue(0)->end()
                                ->scalarNode('policyChecks')->defaultValue(0)->end()
                                ->scalarNode('period')->defaultValue(3600)->end()
                            ->end()
                        ->end()
                        ->arrayNode('by_role')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('policies')->defaultFalse()->end()
                                    ->scalarNode('uploads')->defaultFalse()->end()
                                    ->scalarNode('urls')->defaultFalse()->end()
                                    ->scalarNode('policyChecks')->defaultFalse()->end()
                                    ->scalarNode('period')->defaultFalse()->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end() // quotas
            ->end()
        ->end();

        return $treeBuilder;
    }
}
