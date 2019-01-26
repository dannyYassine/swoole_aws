<?php
define('APP_ROOT', __DIR__);

require 'utils/View.php';

$c = new \Slim\Container(); //Create Your container

//Override the default Not Found Handler before creating App
$c['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $response->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->write(View::get('404'));

    };
};

$app = new \Slim\App($c);
require 'routes.php';
