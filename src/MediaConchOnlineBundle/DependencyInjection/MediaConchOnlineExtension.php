<?php

namespace MediaConchOnlineBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MediaConchOnlineExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('mco.mediaconch.host', $config['mediaconch']['host']);
        $container->setParameter('mco.mediaconch.port', $config['mediaconch']['port']);
        $container->setParameter('mco.mediaconch.api.version', $config['mediaconch']['api_version']);
        $container->setParameter('mco.mediaconch.absolute_url_for_mail', $config['absolute_url_for_mail']);
        $container->setParameter('mco.mediaconch.quotas', $config['quotas']);
    }
}
