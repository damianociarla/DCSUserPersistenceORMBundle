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

        if (!class_exists('Doctrine\ORM\Version')) {
            return;
        }

        $ormCompilerClass = 'Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass';

        if (!class_exists($ormCompilerClass)) {
            return;
        }

        $container->addCompilerPass(
            DoctrineOrmMappingsPass::createXmlMappingDriver([
                realpath(__DIR__ . '/Resources/config/doctrine-core') => 'DCS\User\CoreBundle\Model',
            ])
        );
    }
}