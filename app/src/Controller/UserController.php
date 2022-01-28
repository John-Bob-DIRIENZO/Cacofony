<?php

namespace App\Controller;

use App\Core\Helper\JwtHelper;

class UserController extends BaseController
{
    /**
     * @Route(path="/login", name="login")
     * @return void
     */
    public function getLogin() {
        $this->render('login.html.twig', []);
    }

    /**
     * @Route(path="/register", name="register")
     * @return void
     */
    public function getRegister() {
        $this->render('register.html.twig');
    }

    /**
     * @Route(path="/login", name="login")
     * @return void
     */
    public function postLogin() {

    }

    /**
     * @Route(path="/register", name="register")
     * @return void
     */
    public function postRegister() {
        var_dump($this->post);
    }
}