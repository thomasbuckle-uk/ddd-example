<?php

declare(strict_types=1);

namespace App\User\Application\Query;

use App\Shared\Application\Query\QueryHandlerInterface;
use App\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class FindUsersQueryHandler implements QueryHandlerInterface
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(FindUsersQuery $query): UserRepositoryInterface
    {
        $userRepository = $this->userRepository;

        if (null !== $query->page && null !== $query->itemsPerPage) {
            $userRepository = $userRepository->withPagination($query->page, $query->itemsPerPage);
        }

        return $userRepository;
    }
}
