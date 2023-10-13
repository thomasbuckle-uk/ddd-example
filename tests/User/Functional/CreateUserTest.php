<?php

declare(strict_types=1);

namespace App\Tests\User\Functional;

use App\Shared\Application\Command\CommandBusInterface;
use App\User\Application\Command\CreateUserCommand;
use App\User\Domain\Model\User;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\Password;
use App\User\Domain\ValueObject\UserUsername;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class CreateUserTest extends KernelTestCase
{
    /**
     * @throws \Exception
     */
    public function testCreateUser(): void
    {
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = static::getContainer()->get(UserRepositoryInterface::class);

        /** @var CommandBusInterface $commandBus */
        $commandBus = static::getContainer()->get(CommandBusInterface::class);

        static::assertEmpty($userRepository);

        $commandBus->dispatch(new CreateUserCommand(
            new UserUsername('name'),
            new Email('email@email.com'),
            new Password('password'),
            ['ROLE_ADMIN'],
        ));

        static::assertCount(1, $userRepository);

        /** @var User $user */
        $user = array_values(iterator_to_array($userRepository))[0];

        static::assertEquals(new UserUsername('name'), $user->username());
        static::assertEquals(new Email('email@email.com'), $user->email());
        static::assertEquals(new Password('password'), $user->password());
        static::assertEquals(['ROLE_USER'], $user->roles());
    }

}