<?php

namespace App\User\Domain\ValueObject;


use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final readonly class Email
{
    #[ORM\Column(name: 'email',length: 180, unique: true)]
    public string $value;

    public function __construct(string $value)
    {
        Assert::email($value);

        $this->value = $value;
    }
}