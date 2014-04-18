<?php


namespace Integration\Sophp\Framework\Metadata\PeerRegistry;


use Sophp\Framework\Metadata\PeerRegistry\Adapter\Memory;
use Sophp\Framework\Metadata\PeerRegistry\PeerRegistryInterface;
use Sophp\Framework\Metadata\PeerRegistry\Model\Peer;

class PeerRegistryTest extends \PHPUnit_Framework_TestCase {
    /** @var  PeerRegistryInterface */
    protected $registry;

    public function setUp() {
        parent::setUp();

        $this->registry = new Memory();
    }

    public function testRegister(){
        $peer = Peer::build()->setId(uniqid());
        $compare = array($peer);
        $this->assertEmpty($this->registry->getList());
        $this->registry->register($peer);
        $this->assertEquals($compare, $this->registry->getList());
    }

    public function testUnregister(){
        $peer = Peer::build()->setId(uniqid());
        $peer2 = Peer::build()->setId(uniqid());
        $compare = array($peer, $peer2);
        $compare2 = array($peer);
        $this->registry->register($peer);
        $this->registry->register($peer2);
        $this->assertEquals($compare, $this->registry->getList());
        $this->registry->unregister($peer2);
        $this->assertEquals($compare2, $this->registry->getList());
    }

    public function testGetList(){
        $compare = array();
        for($i = 0; $i < rand(3,7); $i++){
            $peer = Peer::build()->setId(uniqid());
            $compare[] = $peer;
            $this->registry->register($peer);
        }
        $this->assertEquals($compare, $this->registry->getList());
    }
}
 