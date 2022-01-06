<?php

require './../vendor/autoload.php';

(new \App\Core\Route\Router())->getRoutesFromAnnotations('./../src/Controller')->run();


//$p = $_SERVER["REQUEST_URI"];
//$d = str_replace('?' . $_SERVER['QUERY_STRING'], '', $p);
//var_dump($d);


//$path = explode('/', $_SERVER["REQUEST_URI"])[1] !== '' ? explode('/', $_SERVER["REQUEST_URI"])[1] : '/';
//
//switch ($path) {
//    case "/" :
//        $controller = new \App\Controller\PostController();
//        $controller->home();
//        break;
//    case "show" :
//        $controller = new \App\Controller\PostController();
//        $controller->show();
//        break;
//    default :
//        echo 'rien trouvé';
//}





