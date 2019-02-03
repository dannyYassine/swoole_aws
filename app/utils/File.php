<?php

/**
 * Helper class to server static files from a Swoole Server
 */
class File
{
    static private $static = [
        'css'  => 'text/css',
        'js'   => 'text/javascript',
        'png'  => 'image/png',
        'gif'  => 'image/gif',
        'jpg'  => 'image/jpg',
        'jpeg' => 'image/jpg',
        'mp4'  => 'video/mp4',
        'ttf'  => 'font/ttf'
    ];

    public static function serveStaticFile(swoole_http_request $request, swoole_http_response $response)
    {
        $staticFile = __DIR__ . $request->server['request_uri'];
        if (! file_exists($staticFile)) {
            return false;
        }
        $type = pathinfo($staticFile, PATHINFO_EXTENSION);
        if (! isset(self::$static[$type])) {
            return false;
        }
        $response->header('Content-Type', self::$static[$type]);
        $response->sendfile($staticFile);
        return true;
    }

}