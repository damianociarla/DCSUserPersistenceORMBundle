<?php

namespace DCS\User\Persistence\ORMBundle\Tests;

use DCS\User\Persistence\ORMBundle\DCSUserPersistenceORMBundle;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DCSUserPersistenceORMBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildAddsProviderCompilerPass()
    {
        $containerBuilder = $this->createMock(ContainerBuilder::class);
        $containerBuilder->expects($this->atLeastOnce())
            ->method('addCompilerPass')
            ->with($this->isInstanceOf(DoctrineOrmMappingsPass::class));

        $bundle = new DCSUserPersistenceORMBundle();
        $bundle->build($containerBuilder);
    }
}