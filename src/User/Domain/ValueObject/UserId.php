<?php

namespace App\User\Domain\ValueObject;


use App\Shared\Domain\ValueObject\AggregateRootId;
use Doctrine\ORM\Mapping\Embeddable;
use Stringable;

#[Embeddable]
final class UserId implements Stringable
{
    use AggregateRootId;
}