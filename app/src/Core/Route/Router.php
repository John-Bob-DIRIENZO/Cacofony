<?php

namespace App\Core\Route;

use App\Controller\ErrorController;
use App\Core\Trait\DirectoryParser;
use ReflectionException;

class Router
{
    private array $routesArray = [];
    private array $routes = [];

    use DirectoryParser;

    /**
     * @throws ReflectionException
     */
    public function getRoutesFromAnnotations(string $controllerDirectory): self
    {
        $controllers = $this->getClassesFromDirectory($controllerDirectory);
        foreach ($controllers as $controller) {
            foreach (($reflection = new \ReflectionClass($controller))->getMethods() as $method) {
                if ($method->getDocComment()) {
                    preg_match('#@Route\((.+)\)#', $method->getDocComment(), $routeBloc);
                    if (isset($routeBloc[1])) {
                        $results[$method->getName()]['controller'] = $reflection->getName();
                        $routesConfig = explode(',', str_replace(' ', '', $routeBloc[1]));
                        foreach ($routesConfig as $routeConfig) {
                            preg_match('#(.+)="(.+)"#', $routeConfig, $matches);
                            $results[$method->getName()][$matches[1]] = $matches[2];
                        }
                    }
                }
            }
        }

        foreach ($results as $action => $config) {
            $routes[$config['name'] ?? 'app_' . $action] = [
                'path' => $config['path'],
                'controller' => $config['controller'],
                'action' => lcfirst(str_replace(['get', 'post', 'put', 'path', 'delete'], '', $action)),
            ];
        }

        $this->routesArray = $routes;
        return $this;
    }

    public function getRoutesFromYAML(string $routesFilePath): self
    {
        if (!file_exists($routesFilePath)) {
            throw new \InvalidArgumentException('Ficher non trouvé');
        }

        $this->routesArray = yaml_parse_file($routesFilePath);
        return $this;
    }

    public function run()
    {
        $uri = '/' . trim(explode('?', $_SERVER["REQUEST_URI"])[0], '/');

        foreach ($this->routesArray as $name => $config) {
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