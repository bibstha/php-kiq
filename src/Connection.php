<?php
namespace PhpKiq;

use Enqueue\SimpleClient\SimpleClient;

class Connection
{
    public $_client, $_url, $_receiveTimeout, $_idleTimeout;

    public function __construct(String $url, Int $receiveTimeout = 2000, Int $idleTimeout = 1000)
    {
        $this->_url = $url;
        $this->_receiveTimeout = $receiveTimeout;
        $this->_idleTimeout = $idleTimeout;
    }


    public function connect()
    {
        if (!$this->_client) {
            $this->_client = new SimpleClient($this->_url);
            $this->_client->getQueueConsumer()->setReceiveTimeout($this->_receiveTimeout);
            $this->_client->getQueueConsumer()->setIdleTimeout($this->_idleTimeout);
        }
    }

    public function setAsGlobal()
    {
        self::$client = $this->_client;
    }

    public static $client;

    public static function consume()
    {
        self::$client->consume();
    }
}
