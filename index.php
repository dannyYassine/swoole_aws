<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$http = new Swoole\Http\Server("127.0.0.1", 9501);

$app = new \Slim\App;

$http->on("start", function ($server) use ($app) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
//    $app->run();
});

$http->on("request", function ($request, $response) use ($app) {

    $slimRequest = \Slim\Http\Request::createFromEnvironment(
        new \Slim\Http\Environment([
            'SERVER_PROTOCOL' => 'HTTP/1.1',
            'REQUEST_METHOD' => $request->server['request_method'],
            'REQUEST_URI' => $request->server['request_uri'],
            'SERVER_PORT' => $request->server['server_port'],
            'HTTP_ACCEPT' => $request->header['accept'],
            'HTTP_USER_AGENT' => $request->header['user-agent']
        ])
    );

    $body = new \Slim\Http\Body(fopen('php://temp', 'w'));
    $body->write($request->rawContent());
    $body->rewind();
    $slimRequest = $slimRequest->withBody($body);

    $processedResponse = $app->process($slimRequest, new Slim\Http\Response());

//    // Set all the headers you will find in $processedResponse into swoole's $response
//    $response->header("foo", "bar");

    // Set the body
    $response->end((string) $processedResponse->getBody());
});

$app->get('/', function (Request $request, Response $response, array $args) {
    return file_get_contents('index.html');
});

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});

$http->start();