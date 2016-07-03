<?php

namespace DCS\User\Persistence\ORMBundle\Tests\Manager;

use DCS\User\Persistence\ORMBundle\Manager\Save;

class SaveTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $user;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $entityManager;
    /** @var Save */
    protected $save;

    protected function setUp()
    {
        $this->user = $this->createMock('DCS\User\CoreBundle\Model\UserInterface');
        $this->entityManager = $this->createMock('Doctrine\ORM\EntityManagerInterface');
        $this->save = new Save($this->entityManager);
    }

    public function testSaveAndFlush()
    {
        $this->entityManager->expects($this->exactly(1))->method('persist')->with($this->user);
        $this->entityManager->expects($this->exactly(1))->method('flush');

        call_user_func($this->save, $this->user);
    }

    public function testSaveWithoutFlush()
    {
        $this->entityManager->expects($this->exactly(1))->method('persist')->with($this->user);
        $this->entityManager->expects($this->exactly(0))->method('flush');

        call_user_func_array($this->save, [$this->user, false]);
    }
}