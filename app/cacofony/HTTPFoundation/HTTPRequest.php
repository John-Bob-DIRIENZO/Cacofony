<?php

namespace Cacofony\HTTPFoundation;

class HTTPRequest
{
    /**
     * @param string $key
     * @return mixed|null
     */
    public function cookieData(string $key)
    {
        return $_COOKIE[$key] ?? null;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function cookieExists(string $key): bool
    {
        return isset($_COOKIE[$key]);
    }

    /**
     * @return string
     */
    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return string
     */
    public function requestURI(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * @param string|null $key
     * @return array|mixed
     */
    public function getQuery(string $key = null)
    {
        parse_str($_SERVER['QUERY_STRING'], $queryString);
        $query = $queryString[$key] ?? null;
        return $key ? $query : $queryString;
    }

    /**
     * @param string|null $key
     * @return array|mixed
     */
    public function getRequest(string $key = null)
    {
        return $key ? $_POST[$key] : $_POST;
    }


    public function getFile(string $key = null)
    {
        return $key ? $_FILES[$key] : $_FILES;
    }
}