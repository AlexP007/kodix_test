<?php
require_once __DIR__ . "/../autoload.php";

use app\model\Car;
use components\exceptions\CarAttributeException;
use app\model\CarWorker;

$car = new Car();
try {
    $car->setId('car_5cfff332ce9554.59013663')
        ->setStatus('Снят с продажи')
        ->setPrice(100000)
        ->setBrand('Lexus')
        ->setRun('30000')
        ->setModel('Big one');
    
}
catch (CarAttributeException $exception) {
    print $exception->getMessage();
}

$record = new CarWorker();

print '<pre>';
$result = $record->connect()->get($car);

var_dump($result);


