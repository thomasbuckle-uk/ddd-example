<?php

namespace App\User\Domain\ValueObject;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use Webmozart\Assert\Assert;


#[Embeddable]
final readonly class Name
{
    #[Column(length: 255)]
    public string $value;

    public function __construct(string $value)
    {

        Assert::maxLength($value, 255);

        $this->value = $value;
    }
}