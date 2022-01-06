<?php

namespace App\Controller;

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

    public function render(string $view, array $variables, string $pageTitle)
    {
        $template = './../View/template.php';
        $view = './../View/' . $view . '.php';

        foreach ($variables as $key => $variable) {
            ${$key} = $variable;
        }

        ob_start();
        require $view;
        $content = ob_get_clean();

        $title = $pageTitle;
        require $template;
        exit;
    }

    public function renderJSON($content)
    {
        header('Content-Type: application/json');
        echo json_encode($content, JSON_PRETTY_PRINT);
        exit;
    }

}