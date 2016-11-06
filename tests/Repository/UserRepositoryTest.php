<?php

namespace DCS\User\Persistence\ORMBundle\Tests\Repository;

use DCS\User\CoreBundle\Model\UserInterface;
use DCS\User\Persistence\ORMBundle\Repository\UserRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;

class UserRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    private $em;
    /** @var UserRepository */
    private $userRepository;

    public function setUp()
    {
        $this->em = $this->getMockBuilder(EntityManagerInterface::class)->disableOriginalConstructor()->getMock();
        $classMetadata = $this->getMockBuilder(ClassMetadata::class)->disableOriginalConstructor()->getMock();

        $this->userRepository = new UserRepository($this->em, $classMetadata);
    }

    public function testMethodFindOneBy()
    {
        $this->em->expects($this->once())->method('find');
        $this->userRepository->findOneById('acme');
    }

    public function testMethodFindOneByUsername()
    {
        $query = $this->getMockQuery();
        $query->expects($this->once())->method('getSingleResult')->willReturn($this->getMockBuilder(UserInterface::class)->getMock());

        $queryBuilder = $this->getMockQueryBuilder($query);

        $this->em->expects($this->once())->method('createQueryBuilder')->willReturn($queryBuilder);

        $result = $this->userRepository->findOneByUsername('acme');

        $this->assertNotNull($result);
        $this->assertInstanceOf(UserInterface::class, $result);
    }

    public function testMethodFindOneByUsernameWithNonUniqueResultException()
    {
        $query = $this->getMockQuery();
        $query->expects($this->once())->method('getSingleResult')->willThrowException(new NonUniqueResultException());

        $queryBuilder = $this->getMockQueryBuilder($query);

        $this->em->expects($this->once())->method('createQueryBuilder')->willReturn($queryBuilder);
        $this->assertNull($this->userRepository->findOneByUsername('acme'));
    }

    public function testMethodFindOneByUsernameWithNoResultException()
    {
        $query = $this->getMockQuery();
        $query->expects($this->once())->method('getSingleResult')->willThrowException(new NoResultException());

        $queryBuilder = $this->getMockQueryBuilder($query);

        $this->em->expects($this->once())->method('createQueryBuilder')->willReturn($queryBuilder);
        $this->assertNull($this->userRepository->findOneByUsername('acme'));
    }

    private function getMockQuery()
    {
        return $this->getMockBuilder(AbstractQuery::class)
            ->setMethods(['getSingleResult'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
    }

    private function getMockQueryBuilder($query)
    {
        $queryBuilder = $this->getMockBuilder(QueryBuilder::class)->disableOriginalConstructor()->getMock();
        $queryBuilder->expects($this->once())->method('select')->willReturnSelf();
        $queryBuilder->expects($this->once())->method('from')->willReturnSelf();
        $queryBuilder->expects($this->once())->method('where')->willReturnSelf();
        $queryBuilder->expects($this->once())->method('setParameter')->willReturnSelf();
        $queryBuilder->expects($this->once())->method('getQuery')->willReturn($query);

        return $queryBuilder;
    }
}