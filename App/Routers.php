<?php

namespace App;

class Routers
{
    public static function route()
    {
        //Request routing
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestUri = ltrim($requestUri, '/');
        $requestUri = rtrim($requestUri, '/');
        $factor = explode('/', $requestUri);
        $requestParams = [
            'controller' => (isset($factor[1])) ? $factor[1] : 'Index',
            'action' => (isset($factor[2])) ? $factor[2] : 'Index',
            'params' => []
        ];

        //Parameters mapping
        if (count($factor) > 3) {
            $i = 3;
            while (isset($factor[$i])) {
                $_GET[$factor[$i]] = (isset($factor[$i + 1])) ? $factor[$i + 1] : '';
                $i += 2;
            }
        }

        //Dispatch request
        $dispatcher = new Dispatcher($requestParams);
        $dispatcher->dispatch();
    }
}
