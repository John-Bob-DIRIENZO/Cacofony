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

        $options = array("order" => "idPost DESC");
        $posts = $manager->find("*", null, $options);

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
     * @Route(path="/insertPost", name="insertPost")
     * @return void
     */
    public function getInsertPost()
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

    /**
     * @Route(path="/updatePost", name="updatePost")
     * @return void
     */
    public function getUpdatePost()
    {
        $manager = new PostManager(PDOFactory::getInstance());
        $monPost = array(
            "title" => "Test Update"
        );
        $where = array("column" => "idPost =", "value" => 2);
        if ($manager->update($monPost, $where)) echo "OK";
    }

    /**
     * @Route(path="/getPost/{id}", name="getPost")
     * @return void
     */
    public function getPost(int $id)
    {
        $postManager = new PostManager(PDOFactory::getInstance());
        $columns = "idPost, title, content";
        $where = array("column" => "idPost !=", "value" => 1);
        $options = array("limit" => 2, "order" => "idPost DESC");
        $foundPost = $postManager->find($columns, $where, $options);
        var_dump($foundPost);
    }

    /**
     * @Route(path="/deletePost/{id}", name="deletePost")
     * @return void
     */
    public function getDeletePost(int $id)
    {
        $manager = new PostManager(PDOFactory::getInstance());
        $where = array("column" => "idPost =", "value" => $id);
        var_dump($manager->delete($where));
    }

    /**
     * @Route(path="/countPost", name="countPost")
     * @return void
     */
    public function getCountPost()
    {
        $manager = new PostManager(PDOFactory::getInstance());
        $where = array("column" => "idPost =", "value" => 1);
        echo $manager->count($where);
    }
}
