<?php

namespace Cacofony\Route;

use App\Controller\ErrorController;
use Cacofony\DIC\DIC;
use Cacofony\Entity\Dependency;
use Cacofony\Helper\Regex;
use Cacofony\Trait\DirectoryParser;
use ReflectionException;

class Router
{
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
            $routeName = $config['name'] ?? 'app_' . $action;
            unset($config['name']);
            $config['action'] = lcfirst(str_replace(['get', 'post', 'put', 'patch', 'delete'], '', $action));
            $this->routes[] = new Route($routeName, $config);
        }

        return $this;
    }

    public function getRoutesFromYAML(string $routesFilePath): self
    {
        if (!file_exists($routesFilePath)) {
            throw new \InvalidArgumentException('Ficher non trouvé');
        }

        foreach (yaml_parse_file($routesFilePath) as $name => $config) {
            $this->routes[] = new Route($name, $config);
        }

        return $this;
    }

    public function run()
    {
        $uri = '/' . trim(explode('?', $_SERVER["REQUEST_URI"])[0], '/');

        foreach ($this->routes as $route) {
            if ($route->match($uri)) {
                $controllerClass = $route->getController();

                $controllerActionName = strtolower($_SERVER['REQUEST_METHOD']) . ucfirst($route->getAction());

                foreach ((new \ReflectionClass($controllerClass))->getMethods() as $method) {
                    if ($method->getName() === $controllerActionName) {
                        foreach ($method->getParameters() as $parameter) {
                            $dependencies[] = (new Dependency())
                                ->setName($parameter->getName())
                                ->setType($parameter->getType()->getName())
                                ->setFromURL($parameter->getType()->isBuiltin());
                        }
                    }
                }

                $params = $route->mergeParams($uri);

                foreach ($dependencies ?? [] as $dependency) {
                    if ($dependency->isFromURL()) {
                        $finalParams[$dependency->getName()] = $params[$dependency->getName()];
                    } else {
                        $finalParams[$dependency->getName()] = DIC::autowire($dependency->getType());
                    }
                }
                return new $controllerClass($controllerActionName, $finalParams ?? []);
            }
        }
        return new ErrorController('noRoute');
    }
}