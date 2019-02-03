<?php
require 'vendor/autoload.php';
use Pachico\SlimSwoole\BridgeManager;

require 'app/utils/File.php';

for($i=1;$i<count($argv);$i++){
    putenv($argv[$i]);
}

require 'app/index.php';

$bridgeManager = new BridgeManager($app);
$file = new File(__DIR__);

$host = getenv('APPLICATION_ENV') === 'production' ? '0.0.0.0' : '127.0.0.1';
$port = getenv('APPLICATION_ENV') === 'production' ? 80 : 9501;

$http = new Swoole\Http\Server($host, $port);

$http->set([
    'worker_num' => 4
]);

$http->on("start", function ($server) use ($app) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

$http->on("request", function ($request, $response) use ($bridgeManager, $file) {
    if ($file->serveStaticFile($request, $response)) {
        return;
    }
    $bridgeManager->process($request, $response)->end();
});

$http->start();
