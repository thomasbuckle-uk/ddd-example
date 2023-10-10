<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\User\Domain\Model\User;
use App\User\Domain\Repository\UserRepositoryInterface;

final readonly class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    )
    {
    }

    public function __invoke(CreateUserCommand $command): User
    {
        $user = new User(
            $command->email,
            $command->password,
            $command->username,
        );

        $this->userRepository->save($user);

        return $user;
    }
}