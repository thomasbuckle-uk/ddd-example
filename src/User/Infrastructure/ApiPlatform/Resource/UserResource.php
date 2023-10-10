<?php

declare(strict_types=1);

namespace App\User\Infrastructure\ApiPlatform\Resource;


use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\User\Domain\Model\User;
use App\User\Infrastructure\ApiPlatform\State\Provider\UserCollectionProvider;
use App\User\Infrastructure\ApiPlatform\State\Provider\UserItemProvider;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Validator\Constraints as Assert;
#[ApiResource(
    shortName: 'User', operations: [
    // Queries


    // Commands

    // Basic CRUD
    new GetCollection(
        filters: null,
        provider: UserCollectionProvider::class,
    ),
    new Get(
        provider: UserItemProvider::class,
    )

]
)]
final class UserResource
{
    public function __construct(
        #[ApiProperty(readable: false, writable: false, identifier: true)]
        public ?AbstractUid $id = null,

        #[Assert\NotNull(groups: ['create'])]
        #[Assert\Length(min: 1, max: 255, groups: ['create', 'Default'])]
        public ?string $username = null,

        #[Assert\NotNull(groups: ['create'])]
        #[Assert\Email]
        #[Assert\Length(min: 1, max: 255, groups: ['create', 'Default'])]
        public ?string $email = null,

        #[Assert\NotNull(groups: ['create'])]
        #[Assert\Length(min: 1, max: 255, groups: ['create', 'Default'])]
        public ?string $password = null,

//
//        TODO Implement roles here

//        #[Assert\AtLeastOneOf()]
        public ?array $roles = []

    ){}

    public static function fromModel(User $user): static
    {
        return new self(
            $user->id()->value,
            $user->username()->value,
            $user->email()->value,
            $user->password()->value
        );
    }
}