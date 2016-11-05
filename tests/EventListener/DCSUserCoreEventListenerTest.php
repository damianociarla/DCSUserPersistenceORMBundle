<?php

namespace DCS\User\Persistence\ORMBundle\Tests\EventListener;

use DCS\User\CoreBundle\DCSUserCoreEvents;
use DCS\User\CoreBundle\Event\UserEvent;
use DCS\User\CoreBundle\Model\UserInterface;
use DCS\User\Persistence\ORMBundle\DCSUserPersistenceORMEvents;
use DCS\User\Persistence\ORMBundle\EventListener\DCSUserCoreEventListener;
use DCS\User\Persistence\ORMBundle\Manager\Save;
use DCS\User\Persistence\ORMBundle\Manager\Delete;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DCSUserCoreEventListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject */
    private $save;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    private $delete;
    /** @var DCSUserCoreEventListener */
    private $eventListener;

    public function setUp()
    {
        $this->save = $this->getMockBuilder(Save::class)->disableOriginalConstructor()->getMock();
        $this->delete = $this->getMockBuilder(Delete::class)->disableOriginalConstructor()->getMock();

        $this->eventListener = new DCSUserCoreEventListener($this->save, $this->delete);
    }

    public function testMethodGetSubscribedEvents()
    {
        $this->assertCount(2, $events = DCSUserCoreEventListener::getSubscribedEvents());

        $this->assertArrayHasKey(DCSUserCoreEvents::SAVE_USER, $events);
        $this->assertArrayHasKey(DCSUserCoreEvents::DELETE_USER, $events);

        $this->assertEquals('persistUser', $events[DCSUserCoreEvents::SAVE_USER]);
        $this->assertEquals('removeUser', $events[DCSUserCoreEvents::DELETE_USER]);
    }

    public function testMethodPersistUser()
    {
        $user = $this->getMockBuilder(UserInterface::class)->getMock();

        $userEvent = $this->getMockBuilder(UserEvent::class)->disableOriginalConstructor()->setMethods(['getUser'])->getMock();
        $userEvent->expects($this->once())->method('getUser')->willReturn($user);

        $eventDispatcher = $this->getMockBuilder(EventDispatcherInterface::class)->disableOriginalConstructor()->getMock();
        $eventDispatcher->expects($this->once())->method('dispatch');

        $this->save->expects($this->once())->method('__invoke')->with($user);

        $this->eventListener->persistUser($userEvent, 'ACME', $eventDispatcher);
    }

    public function testMethodRemoveUser()
    {
        $user = $this->getMockBuilder(UserInterface::class)->getMock();

        $userEvent = $this->getMockBuilder(UserEvent::class)->disableOriginalConstructor()->setMethods(['getUser'])->getMock();
        $userEvent->expects($this->once())->method('getUser')->willReturn($user);

        $eventDispatcher = $this->getMockBuilder(EventDispatcherInterface::class)->disableOriginalConstructor()->getMock();
        $eventDispatcher->expects($this->once())->method('dispatch');

        $this->delete->expects($this->once())->method('__invoke')->with($user);

        $this->eventListener->removeUser($userEvent, 'ACME', $eventDispatcher);
    }
}