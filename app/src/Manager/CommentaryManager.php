<?php

namespace App\Manager;

use App\Entity\Commentary;
use App\Core\BaseClasse\BaseManager;
use DateTime;

class CommentaryManager extends BaseManager
{
  public function getCommentariesByPostId(int $articleId)
  {
    $statement = $this->pdo->prepare("
        SELECT Commentaries.id, articleId, content, createdAt, Commentaries.userId, usar.lastname
        FROM Commentaries
        LEFT JOIN usar on usar.id = Commentaries.userId
        WHERE Commentaries.articleId = $articleId
    ");
    $statement->execute();
    $statement->setFetchMode(\PDO::FETCH_ASSOC);
    
    $results = $statement->fetchAll();

    return $results ?? [];
  }

  // public function getUserById(int $userId)
  // {
  //   $statement = $this->pdo->prepare("
  //       SELECT lastname
  //       FROM usar
  //       WHERE usar.id = $userId
  //   ");

  //   $statement->execute();
  //   $statement->setFetchMode(\PDO::FETCH_ASSOC);

  //   $results = $statement->fetch();

  //   return $results ?? '';
  // }
  
  public function postCommentary(int $articleId, int $userId, string $content)

    {
      $query = "INSERT INTO `Commentaries`(`articleId`, `userId`, `content`, `createdAt`) VALUES ($articleId, $userId, '$content')";
    
    
      $stmnt = $this->pdo->prepare($query);
      $stmnt->execute();
      return;
    }

}
