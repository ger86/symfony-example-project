<?php

namespace App\Service\User;

use App\Entity\User;
use App\Event\User\UserCreated;
use App\Repository\UserRepository;
use App\Service\EventDispatcherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUser
{
    public function __construct(
        private UserRepository $userRepository,
        private EventDispatcherInterface $eventDispatcher,
        private UserPasswordHasherInterface $userPasswordHasher
    ) {
    }

    public function __invoke(
        string $email,
        string $plainPassword
    ): User {
        $user = new User($email);
        $password = $this->userPasswordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($password);

        $this->userRepository->save($user);
        $this->eventDispatcher->dispatch(new UserCreated($user->getId()));
        return $user;
    }
}
