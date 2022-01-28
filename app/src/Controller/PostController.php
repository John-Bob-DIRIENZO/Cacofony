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
     * @Route(path="/getPost/{id}", name="getPost")
     * @return void
     */
    public function getPost(int $id)
    {
        $postManager = new PostManager(PDOFactory::getInstance());
        $columns = "idPost, title, content";
        $where = array("idPost !=" => 1, "title !=" => "Test");
        $options = array("limit" => 2, "order" => "idPost DESC");
        $foundPost = $postManager->find($columns, $where, $options);
        $this->render('index.html.twig', ['posts' => $foundPost]);
    }

    /**
     * @Route(path="/insertPost", name="insertPost")
     * @return void
     */
    public function postInsertPost()
    {
        $manager = new PostManager(PDOFactory::getInstance());
        $monPost = new Post(array(
            "title" => $this->post["title"],
            "content" => $this->post["content"],
            "authorId" => $this->post["authodId"],
            "createdAt" => date("Y-m-d")
            ));
        $manager->insert($monPost);
        $this->redirect("/");
    }

    /**
     * @Route(path="/updatePost/{id}", name="updatePost")
     * @return void
     */
    public function postUpdatePost(int $id)
    {
        $manager = new PostManager(PDOFactory::getInstance());
        $monPost = array(
            "title" => $this->post["title"],
            "content" => $this->post["content"]
        );
        $where = array("idPost =" => $id);
        $manager->update($monPost, $where);
        $this->redirect("/");
    }

    /**
     * @Route(path="/deletePost/{id}", name="deletePost")
     * @return void
     */
    public function getDeletePost(int $id)
    {
        $manager = new PostManager(PDOFactory::getInstance());
        $where = array("idPost =" => $id);
        $manager->delete($where);
        $this->redirect("/");
    }

    /**
     * @Route(path="/countPost", name="countPost")
     * @return void
     */
    public function getCountPost()
    {
        $manager = new PostManager(PDOFactory::getInstance());
        $where = array("idPost >" => 0);
        echo $manager->count($where);
    }
}
