<?php

declare(strict_types=1);

namespace App\User\Domain\Exception;

use App\User\Domain\ValueObject\UserId;

final class MissingUserException extends \RuntimeException
{
    public function __construct(UserId $id, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf('Cannot find user with id %s', (string) $id), $code, $previous);
    }
}
