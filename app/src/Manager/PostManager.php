<?php

namespace App\Manager;

use App\Core\BaseClasse\BaseManager;

class PostManager extends BaseManager
{

  public function postCreate(int $userId, string $title, string $image, string $content)

    {
      $query = "INSERT INTO `Post`(`userId`, `title`, `image`, `content`) VALUES ($userId, '$title', '$image', '$content')";
      $stmnt = $this->pdo->prepare($query);
      $stmnt->execute();
      return;
    }
}
