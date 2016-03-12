<?php

namespace DCS\User\Persistence\ORMBundle\Manager;

use DCS\User\CoreBundle\Model\UserInterface;
use Doctrine\ORM\EntityManagerInterface;

class Delete
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Delete user instance from database
     *
     * @param UserInterface $user User instance to persist
     * @param bool $flush Flag to flush all changes
     */
    public function __invoke(UserInterface $user, $flush = true)
    {
        $this->entityManager->remove($user);

        if ($flush) {
            $this->entityManager->flush();
        }
    }
}