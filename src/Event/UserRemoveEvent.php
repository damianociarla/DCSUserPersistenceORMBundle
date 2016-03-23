<?php

namespace DCS\User\Persistence\ORMBundle\Event;

use DCS\User\CoreBundle\Model\UserInterface;
use Symfony\Component\EventDispatcher\Event;

class UserRemoveEvent extends Event
{
    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @var callable
     */
    private $remove;

    public function __construct(UserInterface $user, callable $remove)
    {
        $this->user = $user;
        $this->remove = $remove;
    }

    /**
     * Get user
     *
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get manager
     *
     * @return callable
     */
    public function getRemove()
    {
        return $this->remove;
    }
}