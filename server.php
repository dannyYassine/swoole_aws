<?php
require 'vendor/autoload.php';
use Pachico\SlimSwoole\BridgeManager;

require 'app/index.php';

$bridgeManager = new BridgeManager($app);

$http = new Swoole\Http\Server("127.0.0.1", 9501);

$http->on("start", function ($server) use ($app) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

$http->on("request", function ($request, $response) use ($bridgeManager) {
    $bridgeManager->process($request, $response)->end();
});

$http->start();