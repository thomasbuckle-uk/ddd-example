<?php

declare(strict_types=1);

use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Infrastructure\ApiPlatform\State\Processor\CreateUserProcessor;
use App\User\Infrastructure\ApiPlatform\State\Provider\UserCollectionProvider;
use App\User\Infrastructure\ApiPlatform\State\Provider\UserItemProvider;
use App\User\Infrastructure\Doctrine\DoctrineUserRepository;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {

    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('App\\User\\', dirname(__DIR__, 2) . '/src/User');

    //processors
    $services->set(CreateUserProcessor::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_processor', ['priority' => 0]);

    //providers
    $services->set(UserItemProvider::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_provider', ['priority' => 0]);
    $services->set(UserCollectionProvider::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_provider', ['priority' => 0]);


    // repositories
    $services->set(UserRepositoryInterface::class)
        ->class(DoctrineUserRepository::class);
};