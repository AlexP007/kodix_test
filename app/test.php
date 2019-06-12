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
    $car->setUniqId()
        ->setStatus('Снят с ПРодажи')
        ->setPrice(102000)
        ->setBrand('Mersedes')
        ->setRun('20000')
        ->setModel('s300');
    
}
catch (CarAttributeException $exception) {
    print $exception->getMessage();
}

$record = new CarWorker();

print '<pre>';
$result = $record->connect()->post($car);

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

//$data = new ResponseCarData(Car::createFromDb($result));

//var_dump($data);
//print_r(Car::createFromDb($result));
//print_r($data);

//$response = new \app\model\Response();
//
//$response->addData($data)->createResponse()->send();





