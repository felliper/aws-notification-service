<?php


use IbookingBR\AWSNotificationService\NotificationService;

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

    public function testPublishTrue(){

    }


    public function testConvertMessageToString(){
        $convertMessageToString = self::getMethod('convertMessageToString');
        $this->assertEquals('Message test.',$convertMessageToString->invokeArgs($this->notificationService,['Message test.', NotificationService::DATA_TYPE_STRING]));
        $this->assertEquals('{"foo":1,"bar":"ssss"}',$convertMessageToString->invokeArgs($this->notificationService,[['foo' => 1, 'bar' => 'ssss'], NotificationService::DATA_TYPE_ARRAY]));
        $this->assertEquals(null,$convertMessageToString->invokeArgs($this->notificationService,['Error', 'not']));
    }

    protected static function getMethod($name) {
        $class = new ReflectionClass(NotificationService::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}