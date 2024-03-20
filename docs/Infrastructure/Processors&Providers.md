# Processors & Providers

Processors and Providers are our first point of contact for requests coming in via HTTP using API Platform.\
Think of these as the equivalent to Controllers.

Providers are using for "providing" or reading data and sending it back in the Response, these are used when we are _not_ manipulating state. \
Processors are used where we want to manipulate some "state" and possibly return the changed data back in the response.



## Adding a new Processor

- Create a Command + Command handler example in `App\YOUR_DOMAIN\Application\Command`
- Create a Processor Class in `App\YOUR_DOMAIN\Infrastructure\ApiPlatform\State\Processor`
- Validate the request input
```php
        Assert::isInstanceOf($data, UserResource::class);

        Assert::notNull($data->username);
        Assert::notNull($data->email);
        Assert::notNull($data->password);
```
- Build Command Object for example:
```php       
    $command = new CreateUserCommand(
      new UserUsername($data->username),
      new Email($data->email),
      new Password($data->password),
      []
    );
``` 
- Dispatch the event like so `$model = $this->commandBus->dispatch($command);`
- Return data using the resource class eg `return UserResource::fromModel($model);`
### Adding a new Provider

- Create a new Query and QueryHandly class in `App\YOUR_DOMAIN\Application\Query`
- Create a new Provider class in App\YOUR_DOMAIN\Infrastructure\ApiPlatform\State\Provider
- Following is an example of a `UserCollectionProvider`
```php
$offset = $limit = null;

        if ($this->pagination->isEnabled($operation, $context)) {
            $offset = $this->pagination->getPage($context);
            $limit = $this->pagination->getLimit($operation, $context);
        }

        /** @var UserRepositoryInterface $models */
        $models = $this->queryBus->ask(new FindUsersQuery($offset, $limit));
        $resources = [];

        foreach ($models as $model) {
            $resources[] = UserResource::fromModel($model);
        }

        if (null !== $paginator = $models->paginator()) {
            $resources = new Paginator(
                new \ArrayIterator($resources),
                (float)$paginator->getCurrentPage(),
                (float)$paginator->getItemsPerPage(),
                (float)$paginator->getLastPage(),
                (float)$paginator->getTotalItems(),
            );
        }

        return $resources;
```

## Let API Platform know about our new Provider/Processor

API Platform doesn't know anything about our new operations so we need to configure how we want our new endpoints to act

Navigate to `App\YOUR_DOMAIN\Infrastructure\ApiPlatform\Resource\` and open the relevant resource file

Using attributes at the top of the file add in your configuration for example:

```php
    new Post(
        processor: CreateUserProcessor::class
    )
```

For more information on Resources check out the Resources documentation.


### Configure the new classes as Services

Add in your new Processor/Provider into the services/YOUR_DOMAIN.php file

For example

```php 
 # config/services/user.php
    $services->set(CreateUserProcessor::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_processor', ['priority' => 0]);
```