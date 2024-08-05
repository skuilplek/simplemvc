<?php

require_once('config.php');
require_once('src/core/functions.php');

spl_autoload_register('mvcAutoloader');

function mvcAutoloader($className) {
    $baseDir = __DIR__ . '/src/';

    $directories = [
        'core/',
        'models/',
    ];

    foreach ($directories as $directory) {
        $filePath = $baseDir . $directory . strtolower($className) . '.php';
        if (file_exists($filePath)) {
            require_once $filePath;
            return true;
        }
    }

    return false;
}

/** Descriptiong here */