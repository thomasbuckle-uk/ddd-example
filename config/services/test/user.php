<?php

declare(strict_types=1);

use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Infrastructure\Doctrine\DoctrineUserRepository;
use App\User\Infrastructure\InMemory\InMemoryUserRepository;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    // repositories
    $services->set(UserRepositoryInterface::class)
        ->class(InMemoryUserRepository::class);

    $services->set(InMemoryUserRepository::class)
        ->public();

    $services->set(DoctrineUserRepository::class)
        ->public();
};
