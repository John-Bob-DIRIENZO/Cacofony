<?php

namespace App\Manager;

use App\Core\Factory\PDOFactory;
use App\Entity\Post;

class PostManager extends BaseManager
{
    public function findAllPosts()
    {
        $query = 'SELECT * FROM Post';
        $stmnt = $this->pdo->query($query);

        $result = $stmnt->fetchAll(\PDO::FETCH_ASSOC)[0];

        return new Post($result);
    }
}