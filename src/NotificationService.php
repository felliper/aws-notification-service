<?php
namespace Felliper\AWSNotificationService;

use Aws\Sns\SnsClient;
use Exception;

class NotificationService
{

    const DATA_TYPE_ARRAY = 'array';
    const DATA_TYPE_STRING = 'string';

    protected $client;

    protected $topic;

    /**
     * NotificarionService constructor.
     * @throws Exception
     */
    public function __construct($key, $secret, $region = 'us-east-1')
    {
        if(!$key)
            throw new Exception('You must inform $key.');

        if(!$secret)
            throw new Exception('You must inform $secret.');

        $this->client = new SnsClient([
                'region'        => $region,
                'version'       => '2010-03-31',
                'credentials'   => [
                    'key'   => $key,
                    'secret'=> $secret
                ]
            ]);
    }

    /**
     * @param string $topic
     * @return NotificationService $this
     */
    public function setTopic($topic){
        $this->topic = $topic;
        return $this;
    }


    /**
     * @param array|string $message
     * @param string $data_type
     * @return SnsClient
     * @throws Exception
     */
    public function publish($message,$data_type = self::DATA_TYPE_ARRAY){

        $msg = $this->convertMessageToString($message,$data_type);

        $this->client->publish(
            [
                'Message' => $msg,
                'TopicArn' => $this->topic
            ]);

        return $this->client;
    }

    /**
     * @param $message
     * @param $data_type
     * @return string
     * @throws Exception
     */
    private function convertMessageToString($message, $data_type){

        $result = null;

        switch ($data_type){
            case self::DATA_TYPE_ARRAY:
                if(!is_array($message))
                    throw new Exception("Message is not array: ".$data_type);

                $result = \GuzzleHttp\json_encode($message);
                break;
            case self::DATA_TYPE_STRING:
                if(is_array($message))
                    throw new Exception("Message is array: ".$data_type);

                $result = $message;
                break;
            default:
                throw new Exception("Invalid data type: ".$data_type);
        }

        return $result;
    }


}