<?php

namespace Viewpoint\AdminBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('viewpoint_admin');
        $rootNode = $treeBuilder->getRootNode();

        // Define your configuration options here if needed
        $rootNode
        ->children()
            ->arrayNode('email_config')
                ->children()
                    ->scalarNode('no_reply')->defaultValue('noreply@yourdomain.com')->end()
                    ->scalarNode('contact')->defaultValue('contact@yourdomain.com')->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
