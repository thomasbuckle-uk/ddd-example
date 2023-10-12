<?php

namespace App\User\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\ProviderInterface;
use App\Shared\Application\Query\QueryBusInterface;
use App\Shared\Infrastructure\ApiPlatform\State\Paginator;
use App\User\Application\Query\FindUsersQuery;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Infrastructure\ApiPlatform\Resource\UserResource;

final readonly class UserCollectionProvider implements ProviderInterface
{

    public function __construct(
        private QueryBusInterface $queryBus,
        private Pagination        $pagination,
    )
    {
    }

    /**
     * @return Paginator<UserResource>|list<UserResource>
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): Paginator|array
    {

        $offset = $limit = null;

        if ($this->pagination->isEnabled($operation, $context)) {
            $offset = $this->pagination->getPage($context);
            $limit = $this->pagination->getLimit($operation, $context);
        }

        /** @var UserRepositoryInterface $models */
        $models = $this->queryBus->ask(new FindUsersQuery(1, 5));
        $resources = [];

        foreach ($models as $model) {
            $resources[] = UserResource::fromModel($model);
        }

        if (null !== $paginator = $models->paginator()) {
            $resources = new Paginator(
                new \ArrayIterator($resources),
                (float)$paginator->getCurrentPage(),
                (float)$paginator->getItemsPerPage(),
                (float)$paginator->getLastPage(),
                (float)$paginator->getTotalItems(),
            );
        }

        return $resources;

    }
}