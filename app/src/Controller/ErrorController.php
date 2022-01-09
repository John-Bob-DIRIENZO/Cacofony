<?php

namespace App\Controller;

use Cacofony\BaseClasse\BaseController;

class ErrorController extends BaseController
{
    public function noRoute()
    {
        $this->render('Error/404', [], 'Pas de page ici');
    }
}