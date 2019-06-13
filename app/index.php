<?php
require_once __DIR__ . "/../autoload.php";
require_once "constants.php";

use app\controller\Router;
use \component\exception\CarAttributeException;
use \component\exception\CarIdException;
use app\controller\ApiController;

$router = new Router();
$controller = new ApiController();
try {
    if (!$router->getType()) {
        $controller->noData();
        die();
    }
    if ($router->getType() !== 'car') {
        $controller->invalidDataType();
        die();
    } else {
        if ($router->getId()) {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $controller->getById($router->getId());
                die();
            }
        } else {
            $controller->getAll();
            die();
        }
    }
}
catch (CarIdException $exception) {
    $controller->noId($exception);
}
catch (PDOException $exception) {
    $controller->serverError();
}
