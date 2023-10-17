# Domain - General

This layer containers our data and the logic to manipulate the state of that data

Code in this layer is independent of any business process that may trigger it.
This layer is also completely unaware of the Application layer 


The core of our Domain layer are our models, they contain business objects that represent something in the domain.

Another aspect of the domain layer are ValueObjects, these are representations of data that can be grouped into Models or even grouped together on their own or with models to create aggregates. 

To get the terminology correct models value objects and aggregates are all entities. 

This layer can also container interfaces for boundary objects 
