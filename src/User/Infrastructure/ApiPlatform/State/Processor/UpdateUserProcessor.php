<?php

declare(strict_types=1);

namespace App\User\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Shared\Application\Command\CommandBusInterface;
use App\User\Application\Command\UpdateUserCommand;
use App\User\Domain\Model\User;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\Password;
use App\User\Domain\ValueObject\UserId;
use App\User\Domain\ValueObject\UserUsername;
use App\User\Infrastructure\ApiPlatform\Resource\UserResource;
use Webmozart\Assert\Assert;

final readonly class UpdateUserProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        Assert::isInstanceOf($data, UserResource::class);
        Assert::isInstanceOf($context['previous_data'], UserResource::class);

        $command = new UpdateUserCommand(
            new UserId($context['previous_data']->id),
            null !== $data->username ? new UserUsername($data->username) : null,
            null !== $data->email ? new Email($data->email) : null,
            null !== $data->roles ? $data->roles : null,
            null !== $data->password ? new Password($data->password) : null
        );

        /** @var User $model */
        $model = $this->commandBus->dispatch($command);

        return UserResource::fromModel($model);
    }
}