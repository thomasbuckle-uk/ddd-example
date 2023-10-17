# Symfony & API Platform DDD,CQRS Example

## Current issues
- User roles not properly configured, currently just returns ROLE_USER no matter what you set
- Passwords are not setup, currently just plain text passwords are supported

## Future Improvements

- Create commands to automate the creation of classes / configuration to make our lives easier!
- Optimise the creation a dummy test data
- For configurations either use ALL PHP or ALL .yaml
- Setup PHP application to run in docker container

## Setup

- If you have symfony cli installed run `symfony serve`
- Start database using `docker-compose up -d`
- Create database using `bin/console doctrine:database:create -nq`
- Update schema using `bin/console doctrine:schema:update --force -nq`


## _WIP_ - Using Make to manage project

- Currently, having issues getting TLS/HTTPS working with Caddy + WSL2 + Windows, this may work on MacOS as is

- Install the `make` tool https://www.gnu.org/software/make/
- MacOS should be `brew install make`

- `make install`
- `make help` to view all commands such as linters, ci, db management etc

- Will have to manually copy across the root.crt from caddy docker volume and add to system & browser trust store in order to gain HTTPS support

---

## Investigation of Tooling

### Psalm

Psalm is great for ensuring type safety across our code base

### PHPUnit

Standard Testing Library in the PHP world, perhaps investigating the use of Pest PHP may be an option?

### PHP CS Fixer 

A great static analysis library for catching code smells and giving us stats like Cylcomatic Complexity in our code

### Deptrac

A tool I'm really excited to test out as it allows us to apply static analysis to the _architecture_ of our code

