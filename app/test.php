<?php
require_once __DIR__ . "/../autoload.php";
require_once "constants.php";

use app\model\Car;
use component\exception\CarAttributeException;
use app\model\CarWorker;
use component\response\ResponseError;
use component\response\ResponseCarData;


$car = new Car();
try {
    $car->setStatus('Снят с ПРодажи')
        ->setPrice(102000)
        ->setBrand('Mercedes')
        ->setRun('20000')
        ->setModel('s300')
        ->setId('car_5d00db0b0a4181.58063670');
    
}
catch (CarAttributeException $exception) {
    print $exception->getMessage();
}

$record = new CarWorker();

print '<pre>';
$data = $record->connect()->get($car);

$error = new ResponseError(
    [
        'status' => '301',
        'source' => 'someSource',
        'detail' => 'someDetail'
    ]
);

//print json_encode($error);

//print_r(Car::createFromDb($result));
//print json_encode(Car::createFromDb($result));
//print json_encode($error);


//var_dump($data);
//print_r(Car::createFromDb($result));
//print_r($data);

$response = new \app\model\Response();

$response->addData($data)->createResponse()->send();





