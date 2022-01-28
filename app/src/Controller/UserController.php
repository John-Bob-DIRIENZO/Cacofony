<?php

namespace App\Controller;

use App\Core\Factory\PDOFactory;
use App\Core\Helper\JwtHelper;
use App\Manager\UserManager;
use App\Entity\User;

class UserController extends BaseController
{
    /**
     * @Route(path="/login", name="login")
     * @return void
     */
    public function getLogin() {
        $this->render('login.html.twig', ["title" => "Connexion"]);
    }

    /**
     * @Route(path="/register", name="register")
     * @return void
     */
    public function getRegister() {
        $this->render('register.html.twig', ["title" => "Inscription"]);
    }

    /**
     * @Route(path="/login", name="login")
     * @return void
     */
    public function postLogin() {
        $error = null;

        if (strpos($this->post["email"], "@") === false) $error .= "Votre email n'est pas valide\n";
        if (strlen($this->post["password"]) < 8) $error .= "Votre mot de passe est trop court !\n";
        if (strlen($this->post["password"]) > 32) $error .= "Votre mot de passe est trop long !\n";

        if (empty($error)) {
            $manager = new UserManager(PDOFactory::getInstance());

            $where = array(
                "email" => $this->post["email"]
            );
            $user = $manager->find("email, name, password", $where)[0];

            if (!empty($user) && password_verify($this->post["password"], $user["password"])) {
                $this->alert("Connexion OK ! Bienvenue ".$user['name'], parent::ALERT_SUCCESS);
                $this->redirect("/"); die();
            }else {
                $error .= "Email ou mot de passe erroné !";
            }
        }

        $this->alert("Erreur ! - $error", parent::ALERT_ERROR);
        $this->redirect("login");
    }

    /**
     * @Route(path="/register", name="register")
     * @return void
     */
    public function postRegister() {
        $error = null;

        if (strlen($this->post["password"]) < 8) $error .= "Votre mot de passe est trop court !\n";
        if (strlen($this->post["password"]) > 32) $error .= "Votre mot de passe est trop long !\n";
        if (strlen($this->post["name"]) > 64) $error .= "Votre nom est trop long !\n";
        if (strpos($this->post["email"], "@") === false) $error .= "Votre email n'est pas valide.\n";

        if (empty($error)) {
            $manager = new UserManager(PDOFactory::getInstance());

            $user = new User(array(
                "name" => $this->post["name"],
                "email" => $this->post["email"],
                "password" => $this->post["password"]
            ));

            if ($manager->insert($user)) {
                $this->alert("Votre inscription s'est déroulée avec succès ! Vous pouvez maintenant vous connecter", parent::ALERT_SUCCESS);
                $this->redirect("login");
                die();
            }
        }

        $this->alert("Erreur lors de l'inscription : $error", parent::ALERT_ERROR);
        $this->redirect("register");
    }
}