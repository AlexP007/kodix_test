<?php
require_once "autoload.php";

use components\entities\Car;
use components\exceptions\CarAttributeException;
use components\workers\CarWorker;

$car = new Car();
try {
    $car->setId('car_5cfffdbf1cf359.60809174')
        ->setStatus('Снят с продажи')
        ->setPrice(100000);
    
}
catch (CarAttributeException $exception) {
    print $exception->getMessage();
}

$record = new CarWorker();

print '<pre>';
$result = $record->connect()->delete($car);


