<?php
session_start();
require '../vendor/autoload.php';

$settings = require '../config/settings.php';
$container = new \Slim\Container($settings);

require '../config/debugger.php';
require '../config/database.php';
require '../config/view.php';
require '../config/error-handlers.php';
require '../config/controllers.php';
require '../config/helpers.php';


$app = new \Slim\App($container);
require '../config/middlewares.php';
require '../config/routes.php';

$app->run();
