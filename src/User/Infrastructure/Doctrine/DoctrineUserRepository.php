<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine;

use App\Shared\Domain\Repository\PaginatorInterface;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use App\User\Domain\Model\User;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\UserId;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Iterator;


/**
 * @extends DoctrineRepository<User>
 */
final class DoctrineUserRepository extends DoctrineRepository implements UserRepositoryInterface
{

    private const ENTITY_CLASS = User::class;
    private const ALIAS = 'user';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, self::ENTITY_CLASS, self::ALIAS);
    }

    public function save(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    public function remove(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    public function ofId(UserId $id): ?User
    {
        return $this->em->find(self::ENTITY_CLASS, $id->value);
    }

    public function byEmail(Email $email): static
    {
        return $this->filter(static function (QueryBuilder $qb) use ($email): void {
            $qb->where(sprintf('%s.email.value = :email', self::ALIAS))->setParameter('email', $email->value);
        });
    }
}