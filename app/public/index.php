<?php
session_start();
require './../vendor/autoload.php';

//var_dump((new \Cacofony\Test())->getClassesFromDirectory('./../src')); die;


(new \Cacofony\DIC\DIC())
    ->injectParameters('./../config/parameters.yaml')
    ->run('./../src', './../cacofony');

(new \Cacofony\Route\Router())
    ->getRoutesFromAnnotations('./../src/Controller')
    ->run();

