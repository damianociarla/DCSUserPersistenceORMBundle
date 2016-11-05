<?php

namespace DCS\User\Persistence\ORMBundle\Tests\EventListener;

use DCS\User\CoreBundle\Model\UserInterface;
use DCS\User\Persistence\ORMBundle\Event\UserRemoveEvent;

class UserRemoveEventTest extends \PHPUnit_Framework_TestCase
{
    public function testMethods()
    {
        $user = $this->getMockBuilder(UserInterface::class)->getMock();
        $remove = function () { /* no data */ };

        $userRemoveEvent = new UserRemoveEvent($user, $remove);
        $this->assertInstanceOf(UserInterface::class, $userRemoveEvent->getUser());
        $this->assertTrue(is_callable($userRemoveEvent->getRemove()));
    }
}