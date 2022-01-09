<?php
session_start();
require './../vendor/autoload.php';

(new \Cacofony\DIC\DIC())
    ->injectParameters('./../config/parameters.yaml')
    ->run('./../src', './../cacofony');

(new \Cacofony\Route\Router())
    ->getRoutesFromAnnotations('./../src/Controller')
    ->run();

