<?php
require_once "autoload.php";

use components\entities\Car;
use components\exceptions\CarAttributeException;
use model\CarRecord;

$car = new Car();
try {
    $car->setId()
        ->setBrand('Volvo')
        ->setModel('XC-90')
        ->setPrice(1500)
        ->setRun(0)
        ->setStatus('В пути');
}
catch (CarAttributeException $exception) {
    print $exception->getMessage();
}
echo '<pre>';
var_dump($car);
echo '</pre>';
echo '<hr>';

$record = new CarRecord();

$record->connect();

echo '<pre>';
var_dump($record);


