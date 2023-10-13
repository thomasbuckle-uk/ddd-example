<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class DeleteUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(DeleteUserCommand $command): void
    {
        if (null === $user = $this->userRepository->ofId($command->id)) {
            return;
        }

        $this->userRepository->remove($user);
    }
}
