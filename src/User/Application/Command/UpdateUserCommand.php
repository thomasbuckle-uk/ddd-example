<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\CommandInterface;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\Password;
use App\User\Domain\ValueObject\UserId;
use App\User\Domain\ValueObject\UserUsername;

final readonly class UpdateUserCommand implements CommandInterface
{
    public function __construct(
        public UserId $id,
        public ?UserUsername $username = null,
        public ?Email $email = null,
        public ?array $roles = null,
        public ?Password $password = null,
    ) {
    }
}
