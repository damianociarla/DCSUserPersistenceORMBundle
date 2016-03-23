<?php

namespace DCS\User\Persistence\ORMBundle\Manager;

use DCS\User\CoreBundle\Model\UserInterface;
use Doctrine\ORM\EntityManagerInterface;

class Save
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
     * Save user instance to database
     *
     * @param UserInterface $user User instance to persist
     * @param bool $flush Flag to flush all changes
     */
    public function __invoke(UserInterface $user, $flush = true)
    {
        $this->entityManager->persist($user);

        if ($flush) {
            $this->entityManager->flush();
        }
    }
}