<?php

spl_autoload_register(function ($class) {
    $root = '';
    $file = str_replace('\\', '/', $class) . '.php';

    $path = $root . $file;

    if (file_exists($path)) {
        require_once $path;
    } else die('File ' . $path . ' not found');
});