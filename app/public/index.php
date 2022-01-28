<?php
session_start();
require './../vendor/autoload.php';

(new \App\Core\Route\Router())->getRoutesFromAnnotations('./../src/Controller')->run();