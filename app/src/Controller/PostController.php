<?php

namespace App\Controller;

use App\Core\Factory\PDOFactory;
use App\Entity\Post;
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

        $posts = $manager->findAllPosts();
        $this->render('index.html.twig', ['posts' => $posts]);
    }

    /**
     * @Route(path="/show/{id}-{truc}", name="showOne")
     * @param int $id
     * @param string $truc
     * @return void
     */
    public function getShow(int $id, string $truc)
    {
        $this->renderJSON(['message' => $truc, 'parametre' => $id]);
    }

    /**
     * @Route(path="/show")
     * @return void
     */
    public function getShowTest()
    {
        echo 'je suis bien la bonne méthode';
    }

    /**
     * @Route(path="/insertTest", name="insertTest")
     * @return void
     */
    public function getInsertTest()
    {
        $manager = new PostManager(PDOFactory::getInstance());
        $monPost = new Post(array(
            "title" => "Test BDD",
            "content" => "Yoloo",
            "authorId" => 1,
            "createdAt" => date("Y-m-d")
            ));

        if ($manager->insert($monPost)) echo "OK";
    }
}
