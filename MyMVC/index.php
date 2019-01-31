<?php

var_dump("We are in index.php");
?>
<script src="./js/index.js"></script>

<?php
spl_autoload_register();
session_start();

$uri = $_SERVER['REQUEST_URI'];

$self = explode("/", $_SERVER['PHP_SELF']);
array_pop($self);
$replace = implode("/", $self);
$uri = str_replace($replace."/", "", $uri);

$params = explode("/", $uri);
$controllerName = array_shift($params);
$actionName = array_shift($params);

$mvcContext = new \Core\Mvc\MvcContext($controllerName, $actionName, $params);
$app = new \Core\Application($mvcContext);

$app->addBean(\Driver\DatabaseInterface::class,
    new \Driver\PDODatabase("localhost", "root", "", "mvc"));

$app->addBean(\Core\Http\Component\SessionInterface::class,
    new \Core\Http\Component\Session($_SESSION));

$app->registerDependency(\ViewEngine\ViewInterface::class,
    \ViewEngine\View::class);

$app->registerDependency(\Core\Services\Encryption\EncryptionServiceInterface::class,
    \Core\Services\Encryption\BCyptEncryptionService::class);
$app->registerDependency(\Core\Services\Authentication\AuthenticationServiceInterface::class,
    \Core\Services\Authentication\AuthenticationService::class);
$app->registerDependency(\Core\Services\User\UserServiceInterface::class,
    \Core\Services\User\UserService::class);
$app->start();

