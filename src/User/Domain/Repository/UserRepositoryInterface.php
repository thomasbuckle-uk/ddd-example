<?php

declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\Shared\Domain\Repository\RepositoryInterface;
use App\User\Domain\Model\User;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\UserId;

/**
 * @extends RepositoryInterface<User>
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    public function save(User $user): void;

    public function remove(User $user): void;

    public function ofId(UserId $id): ?User;

    public function byEmail(Email $email): static;
}
