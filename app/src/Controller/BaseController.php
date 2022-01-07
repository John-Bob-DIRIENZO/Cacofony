<?php

namespace App\Controller;

use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;

abstract class BaseController
{
    public function __construct(string $action, array $params = [], string $method = 'get')
    {
        $callable = strtolower($method) . ucfirst($action);

        if (!is_callable([$this, $callable])) {
            throw new \RuntimeException("La méthode $callable n'est pas disponible");
        }

        call_user_func_array([$this, $callable], $params);
    }

    /**
     * @param string $template
     * @param array $args
     */
    public function render(string $template, array $args)
    {
        $loader = new FilesystemLoader('../templates');
        $twig = new Environment($loader);

        foreach ($args as $key => $variable) {
            ${$key} = $variable;
        }

        echo $twig->render($template, $args);
        exit;
    }

    public function renderJSON($content)
    {
        header('Content-Type: application/json');
        echo json_encode($content, JSON_PRETTY_PRINT);
        exit;
    }

}
