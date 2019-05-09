<?php


use Felliper\AWSNotificationService\NotificationService;

class NotificationServiceTest extends PHPUnit_Framework_TestCase {

    private $notificationService;

    public function setUp() {
        $this->notificationService = new NotificationService('123','1234');
    }


    /**
     * @expectedException Exception
     */
    public function testConstructorExceptions() {
        (new NotificationService(null,null));
    }

    /**
     * @expectedException Exception
     */
    public function testConstructorExceptions2() {
        (new NotificationService('',null));
    }

    /**
     * @expectedException Exception
     */
    public function testConstructorExceptions3() {
        (new NotificationService(null,''));
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
    }


    /**
     * @expectedException Exception
     */
    public function testConvertMessageToStringErrorDataType(){
        $convertMessageToString = self::getMethod('convertMessageToString');
        $this->assertInstanceOf(Exception::class,$convertMessageToString->invokeArgs($this->notificationService,['Message test.', 'object']));
    }

    /**
     * @expectedException Exception
     */
    public function testConvertMessageToStringErrorDataType2(){
        $convertMessageToString = self::getMethod('convertMessageToString');
        $this->assertInstanceOf(Exception::class,$convertMessageToString->invokeArgs($this->notificationService,[['a','b'], NotificationService::DATA_TYPE_STRING]));
    }

    /**
     * @expectedException Exception
     */
    public function testConvertMessageToStringErrorDataType3(){
        $convertMessageToString = self::getMethod('convertMessageToString');
        $this->assertInstanceOf(Exception::class,$convertMessageToString->invokeArgs($this->notificationService,['String text', NotificationService::DATA_TYPE_ARRAY]));
    }

    protected static function getMethod($name) {
        $class = new ReflectionClass(NotificationService::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}