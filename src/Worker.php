<?php
namespace PhpKiq;

use Enqueue\SimpleClient\SimpleClient;
use Enqueue\Util\JSON;
use Interop\Queue\PsrMessage;
use Interop\Queue\PsrProcessor;

class Worker
{
    public static function perform_async(...$args)
    {
        $topic = static::topic_name();
        self::client()->send($topic, JSON::encode($args));
    }

    public static function bind()
    {
        $topic = static::topic_name();
        self::client()->bind($topic, $topic, function(PsrMessage $psrMessage) {
            $args = JSON::decode($psrMessage->getBody());
            $instance = new static();
            $instance->perform(...$args);
            return PsrProcessor::ACK;
        });
    }

    public static function topic_name()
    {
        return get_called_class();
    }

    protected static function client()
    {
        return Connection::$client;
    }
}

