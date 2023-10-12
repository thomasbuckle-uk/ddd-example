# General

We are using Hexagonal Architecture for this application, this is comprised of three 'layers' 


[//]: # (TODO improve this + add in diagram)
- **Domain** (Most inside layer where our business logic lives, can only know about itself)
- **Application** (Secondmost layer, this layer is comprised of services, commands and querys. Can know about itself and the domain layer) 
- **Infrastructure** (Outside layer that communicates with external code, such as vendor packages, can use code for any of the three layers)


## CQRS

We communicate using Commands and Queries where Commands alter state and Queries return data without altering the state.


## DDD

We separate out code out into valuable "domains" where each is seperated from other "domains", known as "bounded contexts" 

These domains can only communicate with each-other or external services using ports and adapters AKA commands queries.

The benefit of this approach is promoting loose coupling between our component parts as well as the ability to more easily change and adapt to changing business requirements.


