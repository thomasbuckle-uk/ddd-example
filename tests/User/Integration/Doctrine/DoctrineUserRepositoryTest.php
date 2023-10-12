<?php

namespace App\Tests\User\Integration\Doctrine;

use App\Tests\User\DummyFactory\DummyUserFactory;
use App\User\Infrastructure\Doctrine\DoctrineUserRepository;
use App\Shared\Infrastructure\Doctrine\DoctrinePaginator;
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
}