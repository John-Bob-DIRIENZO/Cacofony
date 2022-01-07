<?php
namespace App\Controller;

use App\Core\Factory\PDOFactory;
use App\Manager\ApiManager;

class ApiController extends BaseController {

    private ApiManager $manager;

    /**
     * @Route(path="/api/{crudType}", name="api")
     * @return void
     * @throws \JsonException
     */
    public function getApi($entity, $crudType)
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->manager = new ApiManager(PDOFactory::getInstance());

        echo (is_callable([$this, $crudType])) ? $this->{$crudType}() : $this->throwJSONerror("Type de rêquete CRUD inexistant");
    }

    /**
     * @throws \JsonException
     */
    public function throwJSONerror($message, $prettyprint = false) {
        return ($prettyprint) ? json_encode($message, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT) : json_encode($message, JSON_THROW_ON_ERROR);
    }
}