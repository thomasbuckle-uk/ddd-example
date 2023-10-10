<?php

declare(strict_types=1);

namespace App\User\Application\Query;

use App\Shared\Application\Query\QueryHandlerInterface;
use App\User\Domain\Model\User;
use App\User\Domain\Repository\UserRepositoryInterface;

final readonly class FindUserQueryHandler implements QueryHandlerInterface
{

    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function __invoke(FindUserQuery $query): ?User
    {
        return $this->repository->ofId($query->id);
    }
}