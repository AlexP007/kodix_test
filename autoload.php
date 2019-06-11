<?php

/**
 * autoloader
 */

spl_autoload_register(function($cname){
    require_once str_replace('\\', '/', $cname) . '.php';
});
