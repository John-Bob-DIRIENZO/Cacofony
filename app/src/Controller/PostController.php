<?php

namespace App\Controller;

use App\Core\BaseClasse\BaseController;
use App\Manager\CommentaryManager;
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
    public function getShow(int $id, string $truc, PostManager $postManager, CommentaryManager $commentaryManager)
    {
        /** @var Post $post */
        $post = $postManager->findOneBy('id', $id);

        if (!$post) {
            $this->HTTPResponse->redirect('/');
        }

        $commentaries = $commentaryManager->getCommentariesByPostId($post->getId());
        $this->render('Frontend/showOne', ['post' => $post, 'commentaries' => $commentaries ], $post->getTitle());
    }

        /**
     * @Route(path="/createPost", name="createPost")
     * @param int $id
     * @param string $truc
     * @param PostManager $postManager
     * @return void
     */
    public function getPostPage()
    {
        $this->render('Frontend/createPost', [], "Make your Post !");
    }

    /**
     * @Route(path="/post/{id}/create")
     */
    public function postPost(PostManager $postManager){
        return $postManager->postPost(
        1,
        $_POST['title'],
        $_POST['image'],
        $_POST['content']
        );
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