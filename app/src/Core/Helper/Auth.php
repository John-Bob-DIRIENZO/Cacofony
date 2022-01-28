<?php
namespace App\Core\Helper;

use App\Core\Factory\PDOFactory;
use Firebase\JWT\JWT;
use App\Manager\UserManager;

class Auth
{

    public static function generateJWT($user) {

        $secretKey  = $_ENV['SECRET_KEY'];
        $issuedAt   = new \DateTimeImmutable();
        $expire     = $issuedAt->modify('+1 day')->getTimestamp();      // Ajoute 60 secondes
        $serverName = $_SERVER['SERVER_NAME'];         // Récupéré à partir des données POST filtré

        $data = [
            'iat'  => $issuedAt->getTimestamp(),         // Issued at:  : heure à laquelle le jeton a été généré
            'iss'  => $serverName,                       // Émetteur
            'nbf'  => $issuedAt->getTimestamp(),         // Pas avant..
            'exp'  => $expire,                           // Expiration
            'userName' => $user,                     // Nom d'utilisateur
        ];

        $jwt = JWT::encode($data, $secretKey, 'HS512');
        setcookie("token", $jwt, $expire, "", $serverName);
        $_SESSION["jwt"] = $jwt;
    }

    public static function checkAuthorizationJWT(): mixed
    {

        try {
            $userId = JWT::decode($_SESSION["jwt"], $_ENV['SECRET_KEY'], ['HS512']);
        } catch (\Exception $e) {
            return false;
        }

        $now = new \DateTimeImmutable();
        $serverName = $_SERVER['SERVER_NAME'];

        if ($userId->iss !== $serverName || $userId->nbf > $now->getTimestamp() || $userId->exp < $now->getTimestamp())
        {
            return false;
        }else {
            $manager = new UserManager(PDOFactory::getInstance());

            $where = array(
                "idUser" => $userId->userName
            );
            $user = $manager->find("idUser, email, name, roles", $where, array("limit" => 1));
            return $user[0] ?? false;
        }
    }

}