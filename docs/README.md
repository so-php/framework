# PeeringServiceFactory
`PeeringServiceFactory` implements `AbstractFactoryInterface` for Zend Service Manager. It provides the ability check if any remote zf2 instances can satisfy the requested service. if there is a remote provider, a proxy service will be generated that transparently proxies service calls to the remote server through some RPC mechanism.

## canCreateServiceWithName
The `canCreateServiceWithName` method determines if a service can be provided through one of the available registered peering services. Cached results of `canCreate` are checked first--however if an entry is not available, simultaneous curl requests are executed to all registered peering services (only occurs if request is not a canCreate RPC request). Though multiple curl requests are executed simultaneously, the factory only waits for the first positive response (or until all responses [negative] have returned).

Though `canCreateServiceWithName` only waits for the first provider-positive response from all of the registered providers, each provider that is able to satisfy the requested service will update the persisted metadata registry for the requested service marking itself as one of the (potentially) many providers to the service. Depending on the latency of the network, by the time the call to `createServiceWithName` will be at least one provider, and potentially all providers mapped to the service in the persisted metadata. The load-balancer will simply work with the available providers at the time of execution.

In the event `canCreateServiceWithName` uses cache to check for available providers, a synchronization call will be scheduled to occur after the zf2 application has sent the response. A `canCreateServiceWithName` is forwarded to any registered peering service that doesn't have a positive or negative provider associated listed in the metadata (cache was cleared as result of config change). This allows the cache to be updated in an asynchronous manner to request.

## createServiceWithName
The `createServiceWithName` method uses a load-balancing implementation to pick one of the peering services that has been registered as a provider for the service. Once a provider has been picked, a dynamic proxy service is generated to fulfill the concrete implementation and returned to the caller. Transparently to the caller, all service calls will be proxied through some RPC mechanism to the remote provider.

# ServiceManagerConfigListener
Because an update to the service manager config of any specific zf2 instance may alter the services it provides, when the service_manager config changes any cached provider references need to be updated (cleared) for this provider. As such a configuration listener is used to detect changes and trigger config changed events across all registered peering services.

Bound to LoadModules.Post, this listener hashes the merged service manager config and compare it against the cached merged service manager config hash. If a change is detected, a service manager config changed event is triggered. By default all registered peering services are bound to this event so they can update their provider cache, but additionally other components/mechanisms can bind to the event as well.

# RemoteEventManager
An event manager where "attached" callbacks represent RPC's and are triggered via curl requests. Used to sync clustered zf2 instances for SO-PHP events.

# ResponseSent event
A new ResponseSent event is added to the application event manager. Any component that needs to perform an action that does not impact the performance/response time of the request can bind to the ResponseSent event to be called after the response has been sent to the client. At such a time, the request caller should no longer be blocked waiting for response and can move on with it's on execution while we perform additional processing.

# Peering Service Metadata
In order to cluster the various zf2 instances in play, certain information needs to be persisted in network accessible concurrent write-lock protected storage mechanism. In addition to supporting the zf2 cluster functionality, the metadata storage also acts as a cache mechanism across multiple executions of a single zf2 instance as well as across executions of all zf2 instances. The cache is necessary to prevent the inevitable network storm that result from the instances trying to sync with each other on a per-request basis if the cache wasn't avaialble.

## ServiceName -> Peering Service : Yes ? No.
Every service that is requested through the PeeringServiceFactory is added to a map of peering service to service names which indicates if the peering service provides it. This mapping is both a positive and negative association list--necessary so we can determine the difference between a service not being able to provide a service and just not knowing because we haven't checked yet.

## Peering Service Registry
In order to cluster the various zf2 instances, they all need to know about each other. Part of the SO-PHP framework is a mechanism that prior to dispatch we check the metadata registry to see if the current instance has been registered and do so if necessary. By default, zf2 instances are identified by their server name--but there is a config entry that can be provided to override the value that would be automatically determined.

## RemoteEvent Listener registration
Certain events may be important enough that every zf2 instance needs to be made aware of it. The RemoteEvent Listener registry is a mapping of events to zf2 RPC associations that need to be executed when an event is triggered.
