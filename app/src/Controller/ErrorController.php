<?php

namespace App\Controller;

class ErrorController extends BaseController
{
    public function getNoRoute()
    {
        $this->render('Error/404', [], 'Pas de page ici');
    }
}