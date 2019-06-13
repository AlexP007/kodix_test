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
use app\controller\ApiController;

$router = new Router();
$controller = new ApiController();
$response = new Response();
$record = new CarWorker();
$car = new Car();

try {
    if (!$router->getType()) {
        $controller->noData();
    }
    if ($router->getType() !== 'car') {
        $controller->invalidDataType();
    } else {
        if ($router->getId()) {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $controller->getById($router->getId());
            }
        } else {
            $controller->getAll();
        }
    }
}
catch (CarIdException $exception) {
    $controller->noId($exception);
}
catch (PDOException $exception) {
    $controller->serverError();
}
