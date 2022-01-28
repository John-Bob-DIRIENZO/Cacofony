<?php
namespace App\Core\Helper;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHelper
{
    private $secretKey;
    private $serverName;

    public function __construct() {
        $this->secretKey = $_ENV['SECRET_KEY'];
        $this->serverName = $_SERVER['SERVER_NAME'];
    }

    public function generateJWT($username) {

        $secretKey  = $this->secretKey;
        $issuedAt   = new DateTimeImmutable();
        $expire     = $issuedAt->modify('+6 minutes')->getTimestamp();      // Ajoute 60 secondes
        $serverName = $this->serverName;         // Récupéré à partir des données POST filtré

        $data = [
            'iat'  => $issuedAt->getTimestamp(),         // Issued at:  : heure à laquelle le jeton a été généré
            'iss'  => $serverName,                       // Émetteur
            'nbf'  => $issuedAt->getTimestamp(),         // Pas avant..
            'exp'  => $expire,                           // Expiration
            'userName' => $username,                     // Nom d'utilisateur
        ];

        setcookie("jwt", JWT::encode($data, $secretKey, 'HS512'), $expire, "", $serverName);
    }

    public function checkAuthorizationJWT() {
        $token = JWT::decode($_COOKIE["jwt"], $this->secretKey, ['HS512']);
        $now = new DateTimeImmutable();
        $serverName = $this->serverName;

        if ($token->iss !== $serverName ||
            $token->nbf > $now->getTimestamp() ||
            $token->exp < $now->getTimestamp())
        {
            header('HTTP/1.1 401 Unauthorized');
            exit;
        }
    }
}