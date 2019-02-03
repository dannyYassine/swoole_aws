<?php

/**
 * Helper class to server static files from a Swoole Server
 */
class File
{
    /**
     * Allowed files to be served
     * @var array
     */
    private static $static = [
        'css'  => 'text/css',
        'js'   => 'text/javascript',
        'png'  => 'image/png',
        'gif'  => 'image/gif',
        'jpg'  => 'image/jpg',
        'jpeg' => 'image/jpg',
        'mp4'  => 'video/mp4',
        'ttf'  => 'font/ttf'
    ];

    /**
     * @var string
     */
    private $directory;

    /**
     * File constructor.
     * @param string $directory
     */
    public function __construct($directory = __DIR__)
    {
        $this->directory = $directory;
    }

    /**
     * @param swoole_http_request $request
     * @param swoole_http_response $response
     * @return bool
     */
    public function serveStaticFile(swoole_http_request $request, swoole_http_response $response)
    {
        $staticFile = $this->directory . $request->server['request_uri'];
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