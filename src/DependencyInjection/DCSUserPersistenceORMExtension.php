<?php

namespace DCS\User\Persistence\ORMBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class DCSUserPersistenceORMExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('manager.xml');
        $container->setAliases([
            'dcs_user.persistence.orm.manager.delete' => $config['manager']['delete'],
            'dcs_user.persistence.orm.manager.save' => $config['manager']['save']
        ]);

        $loader->load('listener.xml');
        $loader->load('repository.xml');
    }
}