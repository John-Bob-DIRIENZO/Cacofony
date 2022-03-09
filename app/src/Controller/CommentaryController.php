<?php

namespace App\Controller;

use App\Core\BaseClasse\BaseController;
use App\Manager\CommentaryManager;
use App\Service\ExampleService;
use PDO;

class CommentaryController extends BaseController
{
  // /**
  //  * @Route(path="/", name="homePage")
  //  * @param PostManager $postManager
  //  * @param ExampleService $service
  //  * @return void
  //  */
  // public function getHome(PostManager $postManager, ExampleService $service)
  // {
  //     $posts = $postManager->findAll();
  //     $this->render('Frontend/home', [
  //         'posts' => $posts,
  //         'strongText' => $service->getStrong('je suis du texte qui vient d\'un service en autowiring'),
  //         'appSecret' => $service->getAppSecret()
  //     ], 'Le titre de la page');
  // }

  // /**
  //  * @Route(path="/show/{id}-{truc}", name="showOne")
  //  * @param int $id
  //  * @param string $truc
  //  * @param PostManager $postManager
  //  * @return void
  //  */
  // public function getShow(int $id, string $truc, PostManager $postManager)
  // {
  //     $post = $postManager->findOneBy('id', $id);
  //     if (!$post) {
  //         $this->HTTPResponse->redirect('/');
  //     }
  //     $this->render('Frontend/showOne', ['post' => $post], $truc);
  // }


  // public function postCommentary(CommentaryManager $commentaryManager)
  // {
  //     $commentaryManager->postCommentary([
  //         'articleId' => $_POST['articleId'],
  //         'content' => $_POST['comment']
  //     ]);
  //     exit();
  // }

  /**
   * @Route(path="/post/{id}/comment")
   */
    public function postCommentary(int $id, CommentaryManager $commentaryManager){
      return $commentaryManager->postCommentary(
        $id,
        1,
        $_POST['content']
      );
    }
}