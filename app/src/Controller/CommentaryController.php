<?php

namespace App\Controller;

use App\Core\BaseClasse\BaseController;
use App\Manager\CommentaryManager;
use App\Service\ExampleService;
use PDO;

class CommentaryController extends BaseController
{
  /**
   * @Route(path="/post/{articleId}/comment")
   */
    public function postCommentary(int $articleId, CommentaryManager $commentaryManager){
      $commentaryManager->postCommentary(
        $articleId,
        1,
        $_POST['content']
      );

      $this->HTTPResponse->redirect('/show/' . $articleId . '-article');
    }
}