<?php

namespace App\Manager;

use App\Entity\Commentary;
use App\Core\BaseClasse\BaseManager;
use DateTime;

class CommentaryManager extends BaseManager
{
  // public function postCommentary(int $articleId, int $userId, string $content, DateTime $createdAt)
  //   {
  //     $query = 'INSERT INTO Commentaries (articlesId, userId, content, createdAt) VALUES ('. $articleId .', '. $userId .', '. $content .', '. $createdAt .')';
  //     $stmnt = $this->pdo->prepare($query);

  //     return $stmnt->execute();
  //   }
    
  public function postCommentary($commentary)
    {
      $query = $this->db->prepare('INSERT INTO comment (userId, articleId, content) VALUES (:userId, :articleId, :content)');
      $query->bindValue(':userId', $commentary['userId'], \PDO::PARAM_INT);
      $query->bindValue(':articleId', $commentary['articleId'], \PDO::PARAM_INT);
      $query->bindValue(':createdAt', $commentary['createdAt'], \PDO::PARAM_INT);
      $query->bindValue(':content', nl2br(htmlspecialchars($commentary['content'])), \PDO::PARAM_STR);
      
      var_dump($query);
      return $query->execute();
    }

}
