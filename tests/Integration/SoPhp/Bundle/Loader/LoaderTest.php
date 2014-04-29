<?php


namespace Integration\SoPhp\Bundle\Loader;


use ArrayObject;
use SoPhp\Framework\Bundle\Loader\Loader;
use Test\SoPhp\Framework\Bundle\One\Two\TooDeep\Bundle as TooDeep;
use Test\SoPhp\Framework\Bundle\One\Two\Bundle as Two;
use Test\SoPhp\Framework\Bundle\One\Bundle as One;
use Test\SoPhp\Framework\Bundle\Bundle as Bundle;

class LoaderTest extends \PHPUnit_Framework_TestCase {
    /** @var  Loader */
    protected $loader;

    public function setUp() {
        parent::setUp();

        $this->loader = new Loader();
    }

    public function testLoadFindsRequiresAndInstantiatesBundles(){
        $config = array(
            'bundles' => array(
                'deployDir' => __DIR__ . '/../../../../Test/SoPhp/Framework/Bundle',
                'searchDepth' => 2
            ),
        );
        $this->loader->setConfig(new ArrayObject($config));
        $bundles = $this->loader->load();

        $this->assertLoadedBundleBundle($bundles);
        $this->assertLoadedOneBundle($bundles);
        $this->assertLoadedTwoBundle($bundles);
        $this->assertDidNotLoadTooDeepBundle($bundles);
    }

    protected function assertLoadedBundleBundle($bundles){
        $this->assertLoadedBundle(new Bundle(), $bundles);
    }

    protected function assertLoadedOneBundle($bundles){
        $this->assertLoadedBundle(new One(), $bundles);
    }

    protected function assertLoadedTwoBundle($bundles){
        $this->assertLoadedBundle(new Two(), $bundles);
    }

    protected function assertDidNotLoadTooDeepBundle($bundles){
        $found = false;
        foreach($bundles as $bundle){
            if($bundle instanceof TooDeep){
                $found = true;
                break;
            }
        }
        $this->assertFalse($found);
    }

    protected function assertLoadedBundle($expected, $bundles){
        $found = false;
        foreach($bundles as $bundle){
            if($bundle instanceof $expected){
                $found = true;
                break;
            }
        }
        $this->assertTrue($found);
    }
}
 