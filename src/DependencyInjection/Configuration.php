<?php

namespace DCS\User\Persistence\ORMBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dcs_user_persistence_orm');

        $rootNode
            ->children()
                ->arrayNode('manager')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('save')
                            ->defaultValue('dcs_user.persistence.orm.manager.save.default')
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('delete')
                            ->defaultValue('dcs_user.persistence.orm.manager.delete.default')
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}