<?php

namespace Viewpoint\AdminBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class ViewpointAdminExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml'); 
        
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // Set the configuration options in the container

        if(isset($config['email_config']['no_reply'])){
            $container->setParameter('viewpoint_admin.email_config.no_reply', $config['email_config']['no_reply']);
        }
        if(isset($config['email_config']['contact'])){
            $container->setParameter('viewpoint_admin.email_config.contact', $config['email_config']['contact']);
        }
        
    }

    public function prepend(ContainerBuilder $container){
        // Prepend the configuration to make it available
        // $config = $container->getExtensionConfig($this->getAlias());
        // dd($config);
    }
    
}
