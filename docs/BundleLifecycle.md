# Adapting to stateless nature of PHP.
Like it's OSGI influence, SO-PHP bundles too have a life-cycle. However, the SO-PHP bundle life-cycle has been adapted to suit typical execution flow of PHP programs. Unlike java OSGI containers that typically are started on the server and run for long periods of time that service multiple requests--SO-PHP is a request oriented framework. The entire framework is bootstrapped, configured, executed and torn down on a per-request basis.

Given an appropriate persistence mechanism it is feasible (and preferred) that a bundle transition it's various stages over multiple executions. For instance, it is not necessary that a bundle undergo installation, resolving and activating for every single request that is processed by the framework. Rather, the bundle could and should be installed, resolved and perhaps activated by a (administrative) request and it's active state persisted in storage. In subsequent requests, the "active" bundle is loaded from memory to be utilized to service the request, or other services triggered by the request.

Therefore, the SO-PHP framework is designed such that at the tail end of a PHP execution, any bundles that were loaded in memory (installed, resolved, activated etc) are serialized and saved to persistent storage. Also, at the beginning of each PHP execution bundles are loaded from storage and unserialized into active memory to their last state.

## Bundle Life-Cycle

### Installed
A bundle's state is depicted as installed when the bundle package is discovered in the file system and has not been registered in the system. The framework has a special location that it checks for bundle packages--and does so at the start of every request. (Todo: should this be an administrative action that only occurs when a request for "scan deploy dir" is received? Why waste time/resources scanning file system if this is a request that can/will never install a bundle [servicing web requests]).

### Resolved
A bundle's state is depicted as resolved when its dependencies have been met by the framework. Bundles can specify other services/bundles that it requires to be loaded in order to operate. If the framework does not have access to these resources then it cannot install the bundle. Resolved is an interim state that occurs during a (administrative) request to install start.

### Starting
When the bundle is specified to start, it transitions into a starting state. It remains so until any activators/listeners that have been attached to the bundle have been triggered.

### Active
If the bundle is depicted as active then it is in use by the framework to service requests. Any bundle or service may make use of this bundle and any listeners that have been registered from this bundle for system or bundle events will be triggered (this bundle can now receives notifications of other bundle transitions). This is the state the bundle will reside in for the majority of it's life span. Once installed and started bundles will be loaded, stored, repeat ad nauseam for as many requests that are made upon the framework until it is removed.

### Stopping
When the bundle is specified to stop, it transitions into a stopping state. It remains so until any activators/listeners that have been attached to the bundle have been triggered. Once finished, the bundle will transition to Resolved state.

### Uninstalled
When the bundle has been uninstalled, the in-memory representation of the bundle state is set to uninstalled. No further state transitions can occur for the bundle. The bundle files that reside on the file system have also been deleted.