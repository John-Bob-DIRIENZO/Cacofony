<?php

namespace App\Controller;

use App\Core\BaseClasse\BaseController;

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
        // TODO - Validate credentials and stock a JWT in session
        var_dump($this->HTTPRequest->getRequest('email'), $_POST['password']);
    }

    /**
     * @Route(path="/logout")
     * @return void
     */
    public function getLogout()
    {
        session_destroy();
        $this->HTTPResponse->redirect('/');
    }
}