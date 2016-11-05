<?php

namespace DCS\User\Persistence\ORMBundle\Tests\DependencyInjection;

use DCS\User\Persistence\ORMBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\ArrayNode;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\ScalarNode;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Configuration
     */
    private $configuration;

    protected function setUp()
    {
        $this->configuration = new Configuration();
    }

    public function testInstance()
    {
        $this->assertInstanceOf(ConfigurationInterface::class, $this->configuration);
    }

    public function testGetConfigTreeBuilder()
    {
        $this->assertInstanceOf(TreeBuilder::class, $this->configuration->getConfigTreeBuilder());
    }

    public function testRootNodeNameBuilder()
    {
        $treeBuilder = $this->configuration->getConfigTreeBuilder();
        $this->assertEquals('dcs_user_persistence_orm', $treeBuilder->buildTree()->getName());
    }

    public function testManagerNode()
    {
        $treeBuilder = $this->configuration->getConfigTreeBuilder();

        /** @var ArrayNode $tree */
        $tree = $treeBuilder->buildTree();

        /** @var ArrayNode $children */
        $this->assertArrayHasKey('manager', $children = $tree->getChildren());
        $this->assertInstanceOf(ArrayNode::class, $children['manager']);

        /** @var ArrayNode $manager */
        $manager = $children['manager'];

        /** @var ArrayNode $children */
        $children = $manager->getChildren();

        $this->assertArrayHasKey('save', $children);
        /** @var ScalarNode $save */
        $this->assertInstanceOf(ScalarNode::class, $save = $children['save']);
        $this->assertEquals('dcs_user.persistence.orm.manager.save.default', $save->getDefaultValue());

        $this->assertArrayHasKey('delete', $children);
        /** @var ScalarNode $delete */
        $this->assertInstanceOf(ScalarNode::class, $delete = $children['delete']);
        $this->assertEquals('dcs_user.persistence.orm.manager.delete.default', $delete->getDefaultValue());
    }
}