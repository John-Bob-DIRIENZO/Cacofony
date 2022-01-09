<?php

namespace Cacofony\Route;

use Cacofony\Trait\Hydrator;

class Route
{
    private string $name;
    private string $path;
    private string $controller;
    private string $action;
    private array $params = [];

    use Hydrator;

    public function __construct(string $name, array $config)
    {
        $this->name = $name;
        $this->hydrate($config);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        preg_match_all('/{(\w+)}/', $path, $match);
        $this->params = $match[1];

        $this->path = preg_replace('/{(\w+)}/', '([^/]+)', str_replace('/', '\/', $path));
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @param string $controller
     */
    public function setController(string $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    /**
     * Returns an array with the keys passed in the YAML and the values from the URI
     * @param $path
     * @return array
     */
    public function mergeParams($path): array
    {
        preg_match("#$this->path#", $path, $matches);
        array_shift($matches);
        return array_combine($this->params, $matches);
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array $params
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    public function match(string $path): bool
    {
        return (bool)preg_match("#^($this->path)$#", $path);
    }


}