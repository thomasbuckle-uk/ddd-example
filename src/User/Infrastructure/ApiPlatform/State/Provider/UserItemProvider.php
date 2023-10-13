<?php

declare(strict_types=1);

namespace App\User\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Shared\Application\Query\QueryBusInterface;
use App\User\Application\Query\FindUserQuery;
use App\User\Domain\Model\User;
use App\User\Domain\ValueObject\UserId;
use App\User\Infrastructure\ApiPlatform\Resource\UserResource;
use Symfony\Component\Uid\Uuid;

/**
 * @implements ProviderInterface<UserResource>
 */
final readonly class UserItemProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?UserResource
    {
        /** @var string $id */
        $id = $uriVariables['id'];

        /** @var User|null $model */
        $model = $this->queryBus->ask(new FindUserQuery(new UserId(Uuid::fromString($id))));

        return null !== $model ? UserResource::fromModel($model) : null;
    }
}
