<?php

namespace App\Controller;

use Cacofony\BaseClasse\BaseController;
use App\Manager\PostManager;
use App\Service\ExampleService;

class PostController extends BaseController
{
    /**
     * @Route(path="/", name="homePage")
     * @param PostManager $postManager
     * @param ExampleService $service
     * @return void
     */
    public function getHome(PostManager $postManager, ExampleService $service)
    {
        $posts = $postManager->findAll();
        $this->render('Frontend/home', [
            'posts' => $posts,
            'strongText' => $service->getStrong('je suis du texte qui vient d\'un service en autowiring'),
            'appSecret' => $service->getAppSecret()
        ], 'Le titre de la page');
    }

    /**
     * @Route(path="/show/{id}-{truc}", name="showOne")
     * @param int $id
     * @param string $truc
     * @param PostManager $postManager
     * @return void
     */
    public function getShow(int $id, string $truc, PostManager $postManager)
    {
        $post = $postManager->findOneBy('id', $id);

        if (!$post) {
            $this->HTTPResponse->redirect('/');
        }
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