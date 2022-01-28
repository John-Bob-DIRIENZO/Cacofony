<?php

namespace App\Controller;

use App\Core\Helper\Auth;
use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;

abstract class BaseController
{
    public array $post;
    public array $get;
    public array $files;
    public array $session;
    public mixed $user;

    public const ALERT_SUCCESS = "green";
    public const ALERT_INFO = "blue";
    public const ALERT_WARNING = "yellow";
    public const ALERT_ERROR = "red";

    public function __construct(string $action, array $params = [], string $method = 'get')
    {
        if (!empty($_SESSION["jwt"]))
            $this->user = Auth::checkAuthorizationJWT() ?? false;

        $this->post = $_POST;
        $this->get = $_GET;
        $this->files = $_FILES;
        $this->session = $_SESSION;

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
    public function render(string $template, array $args = [])
    {
        $loader = new FilesystemLoader('../templates');
        $twig = new Environment($loader);

        foreach ($args as $key => $variable) {
            ${$key} = $variable;
        }

        $args["alerts"] = (isset($_SESSION["alerts"])) ? $_SESSION["alerts"] : [];
        $args["user"] = $this->user;

        echo $twig->render($template, $args);
        if (!empty($_SESSION["alerts"])) unset($_SESSION["alerts"]);
        exit;
    }

    public function renderJSON($content)
    {
        header('Content-Type: application/json');
        echo json_encode($content, JSON_PRETTY_PRINT);
        exit;
    }

    public function redirect(string $url) {
        header("Location: $url");
    }

    public function alert(string $message, $type = "green") {
        $_SESSION["alerts"][] = array($type, nl2br($message));
    }
}
