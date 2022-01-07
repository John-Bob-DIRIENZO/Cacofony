<?php

namespace App\Core\Route;

use App\Controller\ErrorController;
use App\Core\Helper\Regex;
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
        if (!is_dir($controllerDirectory)) {
            throw new \InvalidArgumentException('Chemin non valide');
        }

        $controllers = $this->getClassesFromDirectory($controllerDirectory);
        foreach ($controllers as $controller) {
            foreach (($reflection = new \ReflectionClass($controller))->getMethods() as $method) {
                if ($method->getDocComment()) {

                    if ($routeBloc = Regex::readFromDocBloc("Route", $method->getDocComment())) {
                        $results[$method->getName()]['controller'] = $reflection->getName();
                        $routesConfig = explode(',', str_replace(' ', '', $routeBloc));

                        foreach ($routesConfig as $routeConfig) {
                            preg_match('#(.+)="(.+)"#', $routeConfig, $matches);
                            $results[$method->getName()][$matches[1]] = $matches[2];
                        }
                    }
                }
            }
        }

        if (!isset($results)) {
            throw  new \RuntimeException('Il semble qu\'aucune annotation n\'ait été trouvé');
        }

        foreach ($results as $action => $config) {
            $routes[$config['name'] ?? 'app_' . $action] = [
                'path' => $config['path'],
                'controller' => $config['controller'],
                'action' => lcfirst(str_replace(['get', 'post', 'put', 'patch', 'delete'], '', $action)),
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