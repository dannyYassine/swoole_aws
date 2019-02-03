<?php
require 'vendor/autoload.php';
use Pachico\SlimSwoole\BridgeManager;

for($i=1;$i<count($argv);$i++){
    putenv($argv[$i]);
}

require 'app/index.php';

$bridgeManager = new BridgeManager($app);

$host = getenv('APPLICATION_ENV') === 'production' ? '0.0.0.0' : '127.0.0.1';
$port = getenv('APPLICATION_ENV') === 'production' ? 80 : 9501;

$http = new Swoole\Http\Server($host, $port);

$http->set([
    'worker_num' => 4
]);

$http->on("start", function ($server) use ($app) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

$static = [
    'css'  => 'text/css',
    'js'   => 'text/javascript',
    'png'  => 'image/png',
    'gif'  => 'image/gif',
    'jpg'  => 'image/jpg',
    'jpeg' => 'image/jpg',
    'mp4'  => 'video/mp4',
    'ttf'  => 'font/ttf'
];

$http->on("request", function ($request, $response) use ($bridgeManager, $static) {
    if (getStaticFile($request, $response, $static)) {
        return;
    }
    $bridgeManager->process($request, $response)->end();
});

$http->start();

function getStaticFile(
    swoole_http_request $request,
    swoole_http_response $response,
    array $static
) : bool {
    $staticFile = __DIR__ . $request->server['request_uri'];
    if (! file_exists($staticFile)) {
        return false;
    }
    $type = pathinfo($staticFile, PATHINFO_EXTENSION);
    if (! isset($static[$type])) {
        return false;
    }
    $response->header('Content-Type', $static[$type]);
    $response->sendfile($staticFile);
    return true;
}