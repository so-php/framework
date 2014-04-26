<?php


namespace Unit\Framework\Curl\MultiCurl\Status;


class StatusTest extends \PHPUnit_Framework_TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function testWaitOneWhenRequestsAreComplete(){
        $this->markTestIncomplete('todo');
    }

    public function testWaitOneWhenOneRequestIsOutstanding(){
        $this->markTestIncomplete('todo');
    }

    public function testWaitOneWhenTwoRequestsAreOutstanding(){
        $this->markTestIncomplete('todo');
    }

    public function testWaitAllWhenRequestsAreComplete(){
        $this->markTestIncomplete('todo');
    }

    public function testWaitAllWhenOneRequestIsOutstanding(){
        $this->markTestIncomplete('todo');
    }

    public function testWaitAllWhenTwoRequestsAreOutstanding(){
        $this->markTestIncomplete('todo');
    }

    public function testResponseReturnsArrayOfResponses(){
        $this->markTestIncomplete('todo');
    }

    public function testDestructWaitsAllAndClosesHandles(){
        $this->markTestIncomplete('todo');
    }

    public function testIsCompleteReturnsTrue(){
        $this->markTestIncomplete('todo');
    }

    public function testIsCompleteReturnsFalse(){
        $this->markTestIncomplete('todo');
    }

}
 