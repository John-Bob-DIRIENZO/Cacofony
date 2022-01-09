<?php

namespace Cacofony\BaseClasse;

use Cacofony\HTTPFoundation\HTTPRequest;
use Cacofony\HTTPFoundation\HTTPResponse;

abstract class BaseController
{
    protected HTTPRequest $HTTPRequest;
    protected HTTPResponse $HTTPResponse;

    public function __construct(string $action, array $params = [])
    {
        $this->HTTPRequest = new HTTPRequest();
        $this->HTTPResponse = new HTTPResponse();

        if (!is_callable([$this, $action])) {
            throw new \RuntimeException("La méthode $action n'est pas disponible");
        }

        call_user_func_array([$this, $action], $params);
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