<?php
require_once __DIR__ . "/../autoload.php";
require_once "constants.php";

use app\controller\Router;
use \component\exception\CarAttributeException;
use \component\exception\CarIdException;
use \component\exception\TypeException;
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
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($router->checkType() ) {
            $json = $router->getPost();
             if (!$json) {
                 $controller->jsonError();
                 die();
             }
             if (!isset($json->data) ) {
                 $controller->jsonError();
                 die();
             }
             $controller->post($json->data);
             die();
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
        if ($router->checkType() ) {
            $json = $router->getPost();
            if(!property_exists($json, 'id') ) {
                $json->data->id = $router->getId();
            }
            if (!$json) {
                $controller->jsonError();
                die();
            }
            if (!isset($json->data) ) {
                $controller->jsonError();
                die();
            }
            $controller->patch($json->data);
            die();
        }
    } else {
        if ($router->getId()) {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $controller->getById($router->getId());
                die();
            } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                $controller->deleteById($router->getId());
                die();
            }
        } else {
            $controller->getAll();
            die();
        }
    }
}
catch (CarAttributeException $exception) {
    $controller->attrError($exception);
}
catch (CarIdException $exception) {
    $controller->noId($exception);
}
catch (TypeException $exception) {
    $controller->typeError($exception);
}
catch (PDOException $exception) {
    $controller->serverError();
}
catch (Error $exception) {
    $controller->attrError($exception);
}

