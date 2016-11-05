<?php

namespace DCS\User\Persistence\ORMBundle\Tests\DependencyInjection;

use DCS\User\Persistence\ORMBundle\DependencyInjection\DCSRoleProviderORMExtension;
use DCS\User\Persistence\ORMBundle\DependencyInjection\DCSUserPersistenceORMExtension;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DCSUserPersistenceORMExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultConfiguration()
    {
        $container = new ContainerBuilder();

        $mock = $this->getMockBuilder(DCSUserPersistenceORMExtension::class)->setMethods(['processConfiguration'])->getMock();
        $mock->load([], $container);

        $this->assertTrue($container->hasAlias('dcs_user.persistence.orm.manager.delete'));
        $this->assertTrue($container->hasAlias('dcs_user.persistence.orm.manager.save'));

        $this->assertEquals('dcs_user.persistence.orm.manager.delete.default', $container->getAlias('dcs_user.persistence.orm.manager.delete'));
        $this->assertEquals('dcs_user.persistence.orm.manager.save.default', $container->getAlias('dcs_user.persistence.orm.manager.save'));
    }

    public function testCustomConfiguration()
    {
        $container = new ContainerBuilder();

        $configs = [
            'dcs_user_persistence_orm' => [
                'manager' => [
                    'delete' => 'acme.service.delete',
                    'save' => 'acme.service.save',
                ],
            ],
        ];

        $mock = $this->getMockBuilder(DCSUserPersistenceORMExtension::class)->setMethods(['processConfiguration'])->getMock();
        $mock->load($configs, $container);

        $this->assertTrue($container->hasAlias('dcs_user.persistence.orm.manager.delete'));
        $this->assertTrue($container->hasAlias('dcs_user.persistence.orm.manager.save'));

        $this->assertEquals('acme.service.delete', $container->getAlias('dcs_user.persistence.orm.manager.delete'));
        $this->assertEquals('acme.service.save', $container->getAlias('dcs_user.persistence.orm.manager.save'));
    }

    public function testLoadXMLConfiguration()
    {
        $container = new ContainerBuilder();

        $mock = $this->getMockBuilder(DCSUserPersistenceORMExtension::class)->setMethods(['processConfiguration'])->getMock();
        $mock->load([], $container);

        $resources = $container->getResources();
        $this->assertCount(3, $resources);

        /** @var FileResource $resource */
        foreach ($resources as $resource) {
            $this->assertContains(pathinfo($resource->getResource(), PATHINFO_BASENAME), [
                'manager.xml',
                'listener.xml',
                'repository.xml',
            ]);
        }
    }
}