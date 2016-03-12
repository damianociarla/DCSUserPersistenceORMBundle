<?php

namespace DCS\User\Persistence\ORMBundle\Event;

use DCS\User\CoreBundle\Model\UserInterface;
use Symfony\Component\EventDispatcher\Event;

class UserSaveEvent extends Event
{
    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @var callable
     */
    private $save;

    public function __construct(UserInterface $user, callable $save)
    {
        $this->user = $user;
        $this->save = $save;
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
    public function getSave()
    {
        return $this->save;
    }
}