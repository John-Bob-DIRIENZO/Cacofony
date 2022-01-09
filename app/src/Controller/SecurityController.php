<?php

namespace App\Controller;

use Cacofony\BaseClasse\BaseController;
use Cacofony\Helper\AuthHelper;
use Firebase\JWT\JWT;

class SecurityController extends BaseController
{
    /**
     * @Route(path="/login")
     * @return void
     */
    public function getLogin()
    {
        $this->render('Security/login', [], 'Please login');
    }

    /**
     * @Route(path="/login")
     * @return void
     */
    public function postLogin()
    {
        // TODO - Validate credentials for real in DB and fill the payload with more infos
        $jwt = JWT::encode(['user' => $this->HTTPRequest->getRequest('username')], $_ENV['APP_SECRET']);
        $_SESSION['user_badge'] = $jwt;
        $this->HTTPResponse->redirect('/');
    }

    /**
     * @Route(path="/logout")
     * @return void
     */
    public function getLogout()
    {
        AuthHelper::logout();
        $this->HTTPResponse->redirect('/');
    }
}