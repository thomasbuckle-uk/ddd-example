<?php

declare(strict_types=1);

namespace App\Tests\User\DummyFactory;

use App\User\Domain\Model\User;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\Password;
use App\User\Domain\ValueObject\UserUsername;

final class DummyUserFactory
{
    private function __construct()
    {
    }

    public static function createUser(
        string $username = 'username',
        string $email = 'email@me.com',
        string $password = 'password',
        array  $roles = ['ROLE_USER']
    ): User
    {
        return new User(
            new Email($email),
            new Password($password),
            new UserUsername($username)
        );
    }
}