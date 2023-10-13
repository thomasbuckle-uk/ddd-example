<?php

declare(strict_types=1);

namespace App\User\Domain\ValueObject;

use App\Shared\Domain\ValueObject\AggregateRootId;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
final class UserId implements \Stringable
{
    use AggregateRootId;
}
