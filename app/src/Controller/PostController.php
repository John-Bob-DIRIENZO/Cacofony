<?php

namespace App\Controller;

use App\Core\BaseClasse\BaseController;
use App\Core\Factory\PDOFactory;
use App\Manager\PostManager;

class PostController extends BaseController
{
    /**
     * @Route(path="/", name="homePage")
     * @return void
     */
    public function getHome()
    {
        $manager = new PostManager(PDOFactory::getInstance());

        $posts = $manager->findAll();

        $this->render('Frontend/home', ['posts' => $posts], 'le titre de la page');
    }

    /**
     * @Route(path="/show/{id}-{truc}", name="showOne")
     * @param int $id
     * @param string $truc
     * @return void
     */
    public function getShow(int $id, string $truc)
    {
        $manager = new PostManager(PDOFactory::getInstance());
        $post = $manager->findOneBy('id', $id);
        $this->render('Frontend/showOne', ['post' => $post], $truc);
    }

    /**
     * @Route(path="/show")
     * @return void
     */
    public function getShowTest()
    {
        $this->renderJSON(['message' => 'Je suis bien la bonne méthode']);
    }

    /**
     * @Route(path="/show")
     * @return void
     */
    public function postShowTest()
    {
        $this->renderJSON(['message' => 'Ca marche aussi en fonction de la méthode, testez moi !']);
    }
}