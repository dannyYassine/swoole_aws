<?php

$http = new Swoole\Http\Server("127.0.0.1", 9501);

$http->on("start", function ($server) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

$http->on("request", function ($request, $response) {
    $response->end("<h1>Hello World. #".rand(1000, 9999)."</h1>");
});

$http->start();