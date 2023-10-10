Messenger component. You can define your own message buses
or start using the default one right now by injecting the message_bus service
or type-hinting Symfony\Component\Messenger\MessageBusInterface in your code.

* To send messages to a transport and handle them asynchronously:

    1. Update the MESSENGER_TRANSPORT_DSN env var in .env if needed
       and framework.messenger.transports.async in config/packages/messenger.yaml;
    2. (if using Doctrine) Generate a Doctrine migration bin/console doctrine:migration:diff
       and execute it bin/console doctrine:migration:migrate
    3. Route your message classes to the async transport in config/packages/messenger.yaml.
