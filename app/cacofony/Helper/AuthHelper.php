<?php

namespace Cacofony\Helper;

use Firebase\JWT\JWT;

class AuthHelper
{
    public static function isLoggedIn(): bool
    {
        if (!isset($_SESSION['user_badge'])) {
            return false;
        }

        try {
            JWT::decode($_SESSION['user_badge'], $_ENV['APP_SECRET'], ['HS256']);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    // TODO - This method should return an User entity
    public static function getLoggedUser(): object|bool
    {
        try {
            $user = JWT::decode($_SESSION['user_badge'], $_ENV['APP_SECRET'], ['HS256']);
        } catch (\Exception $e) {
            return false;
        }
        return $user;
    }

    public static function login(array $userInfos)
    {

    }

    public static function logout(): void
    {
        session_destroy();
    }
}