<?php

namespace App\Controller;

use App\Core\BaseClasse\BaseController;

class ErrorController extends BaseController
{
    public function noRoute()
    {
        $this->render('Error/404', [], 'Pas de page ici');
    }
}