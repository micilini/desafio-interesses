<?php

/**
 * Front controller
 *
 * PHP version 5.4
 */

/**
 * Composer
 */
require '../vendor/autoload.php';


/**
 * Twig
 */
Twig_Autoloader::register();


/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'initial']);
$router->add('home', ['controller' => 'Home', 'action' => 'index']);
$router->add('admin', ['controller' => 'Admin', 'action' => 'index']);

$router->add('/', ['controller' => 'Home', 'action' => 'initial']);
$router->add('home/', ['controller' => 'Home', 'action' => 'index']);
$router->add('admin/', ['controller' => 'Admin', 'action' => 'index']);

$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('{controller}/{action}/');
$router->add('{controller}/{id:\d+}/{action}/');
    
$router->dispatch($_SERVER['QUERY_STRING']);
