<?php

namespace DCS\User\Persistence\ORMBundle\Tests\EventListener;

use DCS\User\CoreBundle\Model\UserInterface;
use DCS\User\Persistence\ORMBundle\Event\UserSaveEvent;

class UserSaveEventTest extends \PHPUnit_Framework_TestCase
{
    public function testMethods()
    {
        $user = $this->getMockBuilder(UserInterface::class)->getMock();
        $save = function () { /* no data */ };

        $userSaveEvent = new UserSaveEvent($user, $save);
        $this->assertInstanceOf(UserInterface::class, $userSaveEvent->getUser());
        $this->assertTrue(is_callable($userSaveEvent->getSave()));
    }
}