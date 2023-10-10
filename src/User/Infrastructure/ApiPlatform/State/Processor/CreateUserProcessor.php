<?php

namespace App\User\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Shared\Application\Command\CommandBusInterface;
use App\User\Application\Command\CreateUserCommand;
use App\User\Domain\Model\User;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\Password;
use App\User\Domain\ValueObject\UserUsername;
use App\User\Infrastructure\ApiPlatform\Resource\UserResource;
use Webmozart\Assert\Assert;

final readonly class CreateUserProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): UserResource
    {
        Assert::isInstanceOf($data, UserResource::class);

        Assert::notNull($data->username);
        Assert::notNull($data->email);
        Assert::notNull($data->password);

        $command = new CreateUserCommand(
            new UserUsername($data->username),
            new Email($data->email),
            new Password($data->password),
            []
        );

        /** @var User $model*/
        $model = $this->commandBus->dispatch($command);

        return UserResource::fromModel($model);
    }
}