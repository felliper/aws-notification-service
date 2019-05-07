<?php


class NotificationServiceTest extends PHPUnit_Framework_TestCase {

    private $notificationService;

    public function setUp() {
        $this->notificationService = new IbookingBR\AWSNotificationService\NotificationService('123','1234');
    }

    public function testSetTopic() {
        $this->assertObjectHasAttribute('topic', $this->notificationService,"");
        $this->assertEquals($this->notificationService,$this->notificationService->setTopic('aws123'));
        $this->assertAttributeContains('aws123','topic',$this->notificationService);
    }

    public function testPublish(){

    }


}