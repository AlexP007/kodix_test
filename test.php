<?php
require_once "autoload.php";

use components\entities\Car;
use components\exceptions\CarAttributeException;
use components\workers\CarWorker;

$car = new Car();
try {
    $car->setUniqId()
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
$result = $record->connect()->put($car);

var_dump($result);


