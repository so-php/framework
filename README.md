# framework

Service Oriented PHP Framework. Influenced by Java's OSGI. Built on RabbitMQ.


## Design Goals
  * Developers produce and consume Services.
  * Developers create & release small bundles (instead of applications).
  * Local/Remote services distinction abstracted away and hidden from developer.
    * Developers don't produce or consume "web services"*.
    * Developers don't marshal requests or responses*.
  
_note: * items are in regards to implementing a service-oriented-architecture._ 
  
## Design Features  
  * Continuous deployment of new/existing Services without downtime.
  * Multiple versions of Services.
  * A/B Testing of Services.
  * Load balancing of Services.
  * Scale out by adding more nodes to the cluster.

## Contribute
Using waffles.io kanban for story tracking. Feel free to see what is in progress and what is in the backlog. 
Pick an issue, work it, send a pull-request, easy. 
[![Stories in Ready](https://badge.waffle.io/so-php/framework.png?label=ready&title=Ready)](https://waffle.io/so-php/framework)
