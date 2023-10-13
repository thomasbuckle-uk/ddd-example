<?php

namespace App\Tests\User\Integration\Doctrine;

use App\Shared\Infrastructure\Doctrine\DoctrinePaginator;
use App\Tests\User\DummyFactory\DummyUserFactory;
use App\User\Infrastructure\Doctrine\DoctrineUserRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Exception\ExceptionInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class DoctrineUserRepositoryTest extends KernelTestCase
{

    private static Connection $connection;

    /**
     * @throws ExceptionInterface
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        static::$connection = static::getContainer()->get(Connection::class);

        (new Application(static::$kernel))
            ->find('doctrine:database:create')
            ->run(new ArrayInput(['--if-not-exists' => true]), new NullOutput());

        (new Application(static::$kernel))
            ->find('doctrine:schema:update')
            ->run(new ArrayInput(['--force' => true]), new NullOutput());
    }

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        dump('truncating data');
        static::$connection->executeStatement('TRUNCATE "user"');
    }


    /**
     * @throws \Exception
     */
    public function testSave(): void
    {
        /** @var DoctrineUserRepository $repository */
        $repository = static::getContainer()->get(DoctrineUserRepository::class);

        static::assertEmpty($repository);

        $user = DummyUserFactory::createUser();
        $repository->save($user);

        static::assertCount(1, $repository);
    }

    /**
     * @throws \Exception
     */
    public function testRemove(): void
    {
        /** @var DoctrineUserRepository $repository */
        $repository = static::getContainer()->get(DoctrineUserRepository::class);

        $user = DummyUserFactory::createUser();
        $repository->save($user);

        static::assertCount(1, $repository);

        $repository->remove($user);
        static::assertEmpty($repository);
    }

    /**
     * @throws \Exception
     */
    public function testOfId(): void
    {
        /** @var DoctrineUserRepository $repository */
        $repository = static::getContainer()->get(DoctrineUserRepository::class);

        static::assertEmpty($repository);

        $user = DummyUserFactory::createUser();
        $repository->save($user);

        static::getContainer()->get(EntityManagerInterface::class)->clear();

        static::assertEquals($user, $repository->ofId($user->id()));
    }

    public function testWithPagination(): void
    {
        /** @var DoctrineUserRepository $repository */
        $repository = static::getContainer()->get(DoctrineUserRepository::class);
        static::assertNull($repository->paginator());

        $repository = $repository->withPagination(1, 2);

        static::assertInstanceOf(DoctrinePaginator::class, $repository->paginator());
    }

    public function testWithoutPagination(): void
    {
        /** @var DoctrineUserRepository $repository */
        $repository = static::getContainer()->get(DoctrineUserRepository::class);
        $repository = $repository->withPagination(1, 2);
        static::assertNotNull($repository->paginator());

        $repository = $repository->withoutPagination();
        static::assertNull($repository->paginator());
    }

    /**
     * @throws \Exception
     */
    public function testIteratorWithoutPagination(): void
    {
        /** @var DoctrineUserRepository $repository */
        $repository = static::getContainer()->get(DoctrineUserRepository::class);
        static::assertNull($repository->paginator());

        $users = [
            DummyUserFactory::createUser('user1','user1@me.com'),
            DummyUserFactory::createUser('user2','user2@me.com'),
            DummyUserFactory::createUser('user3','user3@me.com'),
        ];
        foreach ($users as $user) {
            $repository->save($user);
        }

        $i = 0;
        foreach ($repository as $user) {
            static::assertSame($users[$i], $user);
            ++$i;
        }
    }

    /**
     * @throws \Exception
     */
    public function testIteratorWithPagination(): void
    {
        /** @var DoctrineUserRepository $repository */
        $repository = static::getContainer()->get(DoctrineUserRepository::class);
        static::assertNull($repository->paginator());

        $users = [
            DummyUserFactory::createUser('user1','user1@me.com'),
            DummyUserFactory::createUser('user2','user2@me.com'),
            DummyUserFactory::createUser('user3','user3@me.com'),
        ];

        foreach ($users as $user) {
            $repository->save($user);
        }

        $repository = $repository->withPagination(1, 2);

        $i = 0;
        foreach ($repository as $user) {
            static::assertContains($user, $users);
            ++$i;
        }

        static::assertSame(2, $i);

        $repository = $repository->withPagination(2, 2);

        $i = 0;
        foreach ($repository as $user) {
            static::assertContains($user, $users);
            ++$i;
        }

        static::assertSame(1, $i);
    }

    public function testCount(): void
    {
        /** @var DoctrineUserRepository $repository */
        $repository = static::getContainer()->get(DoctrineUserRepository::class);

        $users = [
            DummyUserFactory::createUser('user1','user1@me.com'),
            DummyUserFactory::createUser('user2','user2@me.com'),
            DummyUserFactory::createUser('user3','user3@me.com'),
        ];
        foreach ($users as $user) {
            $repository->save($user);
        }

        static::assertCount(count($users), $repository);
        static::assertCount(2, $repository->withPagination(1, 2));
    }

}