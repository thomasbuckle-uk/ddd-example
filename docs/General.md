# General

We are using Hexagonal Architecture for this application, this is comprised of three 'layers' 


[//]: # (TODO improve this + add in diagram)
- **Domain** (Most inside layer where our business logic lives, can only know about itself)
- **Application** (Secondmost layer, this layer is comprised of services, commands and queries. Can know about itself and the domain layer) 
- **Infrastructure** (Outside layer that communicates with external code, such as vendor packages, can use code for any of the three layers)


## CQRS

We communicate using Commands and Queries where Commands alter state and Queries return data without altering the state.


## DDD

We separate out code into valuable "domains" where each is seperated from other "domains", known as "bounded contexts" 

These domains can only communicate with each-other or external services using ports and adapters AKA commands queries.

The benefit of this approach is promoting loose coupling between our component parts as well as the ability to more easily adapt to changing business requirements.


## Dependency Inversion Principle

This principle means that high level modules should not depends on low level modules, both should depend on abstractions.
In our case this means:
- Code inside infrastructure can depend on an application and domain class
- Code inside application can depend on domain but not infrastructure 
- Code inside domain can only depends on itself (and in some small use cases functionality such as using the Ramsey UUID package to make our lives easier)

---

## General Thoughts 

When to use a VO (domain object) over a primitive? If the concept is important/relevant for the domain, if the concept follows rules from the domain: it's a VO. Otherwise, primitives are good enough. We're still in PHP, not in Java.
