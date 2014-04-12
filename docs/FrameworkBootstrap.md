## Essentials
At its core, all you need to bootstrap the framework is a `SystemBundle` factory which is provided via `Sophp\Framework\Bootstrap\Bootstrap`.

    use Sophp\Framework\Bootstrap\Bootstrap;

    $framework = Bootstrap::newSystemBundle();
    $framework->start();

## Configuration
The framework will be configured with sensible defaults automatically, but you can override those defaults as necessary by providing your own configuration to `Bootstrap::newSystemBundle`.

The following setting are configurable:
  * Data storage: The storage provider where framework metadata is persisted
  * Scandir: The path(s) that should be scanned for bundles
  * Auto-Install Bundles: Bundles that should be installed by default (fetching mechanism)
  * Auto-Start Bundles: Bundles that should be started automatically when the framework is started