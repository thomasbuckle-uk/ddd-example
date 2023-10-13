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




