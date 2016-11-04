<?php

namespace DCS\User\Persistence\ORMBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DCSUserPersistenceORMBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $mappingNamespaces = [
            realpath(__DIR__ . '/Resources/config/doctrine-core') => 'DCS\User\CoreBundle\Model',
        ];

        $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver($mappingNamespaces));
    }
}