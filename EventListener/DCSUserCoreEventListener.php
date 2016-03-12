<?php

namespace DCS\User\Persistence\ORMBundle\EventListener;

use DCS\User\CoreBundle\DCSUserCoreEvents;
use DCS\User\CoreBundle\Event\UserEvent;
use DCS\User\Persistence\ORMBundle\DCSUserPersistenceORMEvents;
use DCS\User\Persistence\ORMBundle\Event\UserRemoveEvent;
use DCS\User\Persistence\ORMBundle\Event\UserSaveEvent;
use DCS\User\Persistence\ORMBundle\Manager\Delete;
use DCS\User\Persistence\ORMBundle\Manager\Save;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DCSUserCoreEventListener implements EventSubscriberInterface
{
    /**
     * @var Save
     */
    private $save;

    /**
     * @var Delete
     */
    private $delete;

    public function __construct(Save $save, Delete $delete)
    {
        $this->save = $save;
        $this->delete = $delete;
    }

    public static function getSubscribedEvents()
    {
        return [
            DCSUserCoreEvents::SAVE_USER => 'persistUser',
            DCSUserCoreEvents::DELETE_USER => 'removeUser',
        ];
    }

    public function persistUser(UserEvent $event, $eventName, EventDispatcherInterface $eventDispatcher)
    {
        $user = $event->getUser();
        call_user_func($this->save, $user);

        $eventDispatcher->dispatch(
            DCSUserPersistenceORMEvents::USER_PERSISTED,
            new UserSaveEvent($user, $this->save)
        );
    }

    public function removeUser(UserEvent $event, $eventName, EventDispatcherInterface $eventDispatcher)
    {
        $user = $event->getUser();
        call_user_func($this->delete, $user);

        $eventDispatcher->dispatch(
            DCSUserPersistenceORMEvents::USER_REMOVED,
            new UserRemoveEvent($user, $this->delete)
        );
    }
}