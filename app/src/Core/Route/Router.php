<?php

namespace App\Core\Route;

use App\Controller\ErrorController;

class Router
{
    private string $routesFilePath;
    private array $routes = [];

    public function __construct(string $routesFilePath)
    {
        if (!file_exists($routesFilePath)) {
            throw new \InvalidArgumentException('Ficher non trouvé');
        }

        $this->routesFilePath = $routesFilePath;
    }

    public function run()
    {
        $yaml = yaml_parse_file($this->routesFilePath);
        $uri = '/' . trim(explode('?', $_SERVER["REQUEST_URI"])[0], '/');

        foreach ($yaml as $name => $config) {
            $this->routes[] = new Route($name, $config);
        }

        foreach ($this->routes as $route) {
            if ($route->match($uri)) {
                $controllerClass = $route->getController();
                $params = $route->mergeParams($uri);
                return new $controllerClass($route->getAction(), $params, $_SERVER['REQUEST_METHOD']);
            }
        }
        return new ErrorController('noRoute');
    }
}