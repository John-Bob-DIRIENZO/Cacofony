<?php

namespace App\Controller;

use App\Core\Factory\PDOFactory;
use App\Manager\PostManager;

class PostController extends BaseController
{
    public function getHome()
    {
        $manager = new PostManager(PDOFactory::getInstance());

        $post = $manager->findAllPosts();

        $this->render('Frontend/home', ['francis' => $post], 'le titre de la page');
    }

    public function getShow(int $id, string $truc)
    {
        $this->renderJSON(['message' => $truc, 'parametre' => $id]);
    }

    public function getShowTest()
    {
        echo 'je suis bien la bonne méthode';
    }
}