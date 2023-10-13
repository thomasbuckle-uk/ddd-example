<?php

declare(strict_types=1);

namespace App\User\Domain\ValueObject;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use Webmozart\Assert\Assert;

#[Embeddable]
final readonly class UserRoles
{
    #[Column(name: 'roles', length: 255)]
    public array $value;

    public function __construct(array $value)
    {
        Assert::isArray($value);

        $this->value = $value;
    }

    public function getRoles(): array
    {
        $roles = $this->value;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }
}
