<?php

declare(strict_types=1);

namespace App\User\Domain\ValueObject;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use Webmozart\Assert\Assert;

#[Embeddable]
final readonly class Password
{
    #[Column(name: 'password', length: 255)]
    public readonly string $value;

    public function __construct(string $value)
    {
        Assert::maxLength($value, 255);

        $this->value = $value;
    }
}
