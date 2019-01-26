<?php
define('APP_ROOT', __DIR__);

require 'utils/View.php';

$app = new \Slim\App;
require 'routes.php';
