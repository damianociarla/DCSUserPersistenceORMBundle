<?php

namespace DCS\User\Persistence\ORMBundle\Tests\Manager;

use DCS\User\Persistence\ORMBundle\Manager\Delete;

class DeleteTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $user;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $entityManager;
    /** @var Delete */
    protected $delete;

    protected function setUp()
    {
        $this->user = $this->getMock('DCS\User\CoreBundle\Model\UserInterface');
        $this->entityManager = $this->getMock('Doctrine\ORM\EntityManagerInterface');
        $this->delete = new Delete($this->entityManager);
    }

    public function testDeleteAndFlush()
    {
        $this->entityManager->expects($this->exactly(1))->method('remove')->with($this->user);
        $this->entityManager->expects($this->exactly(1))->method('flush');

        call_user_func($this->delete, $this->user);
    }

    public function testDeleteWithoutFlush()
    {
        $this->entityManager->expects($this->exactly(1))->method('remove')->with($this->user);
        $this->entityManager->expects($this->exactly(0))->method('flush');

        call_user_func_array($this->delete, [$this->user, false]);
    }
}