<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\User\Domain\Exception\MissingUserException;
use App\User\Domain\Model\User;
use App\User\Domain\Repository\UserRepositoryInterface;

final readonly class UpdateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(UpdateUserCommand $command): User
    {
        $user = $this->userRepository->ofId($command->id);

        if (null === $user) {
            throw new MissingUserException($command->id);
        }

        $user->update(
            email: $command->email,
            password: $command->password,
            roles: $command->roles,
            username: $command->username
        );

        $this->userRepository->save($user);

        return $user;
    }

}