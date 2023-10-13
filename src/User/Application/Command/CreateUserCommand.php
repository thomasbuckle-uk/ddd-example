<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\CommandInterface;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\Password;
use App\User\Domain\ValueObject\UserUsername;

final readonly class CreateUserCommand implements CommandInterface
{
    public function __construct(
        public UserUsername $username,
        public Email $email,
        public Password $password,
        public array $roles,
    ) {
    }
}
