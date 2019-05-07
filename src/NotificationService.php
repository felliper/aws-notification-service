<?php
namespace IbookingBR\AWSNotificationService;

use Aws\Sns\SnsClient;

class NotificationService
{

    const DATA_TYPE_ARRAY = 'array';
    const DATA_TYPE_STRING = 'string';

    protected $client;

    protected $topic;

    /**
     * NotificarionService constructor.
     * @param string $key
     * @param string $secret
     * @param string $region
     */
    public function __construct($key, $secret, $region = 'us-east-1')
    {
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
     */
    public function publish($message,$data_type = self::DATA_TYPE_ARRAY){

        $msg = $this->convertMessage($message,$data_type);

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
     */
    private function convertMessage($message,$data_type){

        switch ($data_type){
            case self::DATA_TYPE_ARRAY:
                $result = \GuzzleHttp\json_encode($message);
                break;
            case self::DATA_TYPE_STRING:
            default:
                $result = $message;
        }

        return $result;
    }


}