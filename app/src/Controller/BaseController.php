<?php

namespace App\Controller;

use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;

abstract class BaseController
{
    public $post;
    public $get;
    public $files;

    public function __construct(string $action, array $params = [], string $method = 'get')
    {
        $callable = strtolower($method) . ucfirst($action);

        if (!is_callable([$this, $callable])) {
            throw new \RuntimeException("La méthode $callable n'est pas disponible");
        }

        call_user_func_array([$this, $callable], $params);

        $this->post = $_POST;
        $this->get = $_GET;
        $this->files = $_FILES;
    }

    /**
     * @param string $template
     * @param array $args
     */
    public function render(string $template, array $args = null)
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

    public function redirect($url) {
        header("Location: $url");
    }
}
