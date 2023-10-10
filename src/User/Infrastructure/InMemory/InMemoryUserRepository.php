<?php

declare(strict_types=1);

namespace App\User\Infrastructure\InMemory;

use App\Shared\Infrastructure\InMemory\InMemoryRepository;
use App\User\Domain\Model\User;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\UserId;


/**
 * @extends InMemoryRepository<User>
 */
final class InMemoryUserRepository extends InMemoryRepository implements UserRepositoryInterface
{


    public function save(User $user): void
    {
        $this->entities[(string)$user->id()] = $user;
    }

    public function remove(User $user): void
    {
        unset($this->entities[(string)$user->id()]);
    }

    public function ofId(UserId $id): ?User
    {
        return $this->entities[(string)$id] ?? null;
    }

    public function byEmail(Email $email): static
    {
        return $this->filter(fn(User $user) => $user->email());
    }
}