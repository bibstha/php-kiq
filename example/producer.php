<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../src/Connection.php');
require_once(__DIR__ . '/../src/Worker.php');

use PhpKiq\Connection;
use PhpKiq\Worker;

$connection = new Connection('amqp://guest:random@localhost:5672/%2f');
$connection->connect();
$connection->setAsGlobal();

class WorkerA extends Worker
{
    public function perform($firstname, $lastname)
    {
        echo "Full name is {$firstname}, {$lastname}";
    }
}

class WorkerB extends Worker
{
    public function perform($valA, $valB)
    {
        $sum = $valA + $valB;
        echo "Sum of {$valA} and {$valB} is {$sum}";
    }
}

WorkerA::perform_async("Robert", "Martin");
WorkerB::perform_async(2, 4);
