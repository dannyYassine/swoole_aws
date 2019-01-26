<?php

$http = new Swoole\Http\Server("3.92.223.16", 9501);

$http->on("start", function ($server) {
    echo "Swoole http server is started at http://3.92.223.16:9501\n";
});

$http->on("request", function ($request, $response) {
    $response->header("Content-Type", "application/json");
    $response->send("{id:1}");
});

$http->start();