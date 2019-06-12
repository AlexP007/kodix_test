<?php
require_once __DIR__ . "/../autoload.php";
require_once "constants.php";

use app\controller\Router;
use app\model\Car;
use app\model\Response;
use component\response\ResponseError;
use \component\exception\CarAttributeException;
use \component\exception\CarIdException;
use app\model\CarWorker;

$router = new Router();
$response = new Response();
$record = new CarWorker();
$car = new Car();

try {
    if (!$router->getType()) {
        $response->setSuccess(false)
            ->setHttpStatusCode(422)
            ->addError(
                new ResponseError(
                    [
                        'status' => 422,
                        'source' => ['pointer' => '/'],
                        'detail' => 'Missing `data` Member at document\'s top level.'
                    ]
                )
            )->createResponse()
            ->send();
        die();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if ($router->getType() !== 'car') {
            $response->setSuccess(false)
                ->setHttpStatusCode(422)
                ->addError(
                    new ResponseError(
                        [
                            'status' => 422,
                            'source' => ['pointer' => '/data'],
                            'detail' => 'Invalid`data` Member at document\'s top level.'
                        ]
                    )
                )
                ->createResponse()
                ->send();
        } else {
            if ($router->getId()) {
                $car->setId($router->getId());
                $response->setSuccess(true)
                    ->setHttpStatusCode(200)
                    ->addData(
                        $record->connect()->get($car)
                    )
                    ->createResponse()
                    ->send();
                
            } else {
                $response->setSuccess(true)
                    ->setHttpStatusCode(200)
                    ->addData(
                        $record->connect()->get()
                    )
                    ->createResponse()
                    ->send();
            }
        }
    }  elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
    }
}
catch (CarIdException $exception) {
    $response->setSuccess(false)
        ->setHttpStatusCode(404)
        ->addError(
            new ResponseError(
                [
                    'status' => 404,
                    'source' => ['pointer' => '/data/id'],
                    'detail' => $exception->getMessage()
                ]
            )
        )
        ->createResponse()
        ->send();
}
catch (PDOException $exception) {
    $response->setSuccess(false)
        ->setHttpStatusCode(500)
        ->addError(
            new ResponseError(
                [
                    'status' => 500,
                ]
            )
        )
        ->createResponse()
        ->send();
}
