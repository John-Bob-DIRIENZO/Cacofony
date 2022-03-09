<?php
session_start();
require './../vendor/autoload.php';

(new \App\Core\DIC\DIC())
    ->injectParameters('./../config/parameters.yaml')
    ->run('./../src');

(new \App\Core\Route\Router())
    ->getRoutesFromAnnotations('./../src/Controller')
    ->run();

