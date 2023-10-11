<?php

declare(strict_types=1);

namespace App\User\Domain\Model;

use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\UserId;
use App\User\Domain\ValueObject\Password;
use App\User\Domain\ValueObject\UserUsername;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;


#[ORM\Entity]
class User
{

    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Embedded(class: UserId::class, columnPrefix: false)]
    private readonly UserId $id;

    #[ORM\Column]
    private array $roles = [];

    public function __construct(

        #[ORM\Embedded(class: Email::class,columnPrefix: false)]
        private Email        $email,
//
//        #[ORM\Embedded(columnPrefix: false)]
//        private UserRoles    $roles,

        #[ORM\Embedded(class: Password::class,columnPrefix: false)]
        private Password     $password,

        #[ORM\Embedded(class: UserUsername::class,columnPrefix: false)]
        private UserUsername $username,
    )
    {
        $this->id = new UserId();
    }

    public function update(
        ?Email        $email = null,
        ?Password     $password = null,
        ?array        $roles = null,
        ?UserUsername $username = null,
    ): void
    {
        $this->email = $email ?? $this->email;
        $this->password = $password ?? $this->password;
        $this->roles = $roles ?? $this->roles;
        $this->username = $username ?? $this->username;
    }


    public function id(): ?UserId
    {
        return $this->id;
    }

    public function email(): ?Email
    {
        return $this->email;
    }


    public function roles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }


    public function password(): ?Password
    {
        return $this->password;
    }


    public function username(): ?UserUsername
    {
        return $this->username;
    }


}
