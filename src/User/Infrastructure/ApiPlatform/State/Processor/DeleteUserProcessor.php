<?php

declare(strict_types=1);

namespace App\User\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Shared\Application\Command\CommandBusInterface;
use App\User\Application\Command\DeleteUserCommand;
use App\User\Domain\ValueObject\UserId;
use App\User\Infrastructure\ApiPlatform\Resource\UserResource;
use Webmozart\Assert\Assert;

final readonly class DeleteUserProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): null
    {
        Assert::isInstanceOf($data, UserResource::class);

        $this->commandBus->dispatch(new DeleteUserCommand(new UserId($data->id)));

        return null;
    }
}
