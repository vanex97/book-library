<?php

namespace Src\security;

use Framework\Database;

class AdminBasicAuth
{
    public static function require_auth()
    {
        $login = $_SERVER['PHP_AUTH_USER'] ?? null;
        $pass = $_SERVER['PHP_AUTH_PW'] ?? null;

        header('Cache-Control: no-cache, must-revalidate, max-age=0');
        $has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));
        $is_not_authenticated = (
            !$has_supplied_credentials ||
            !self::checkAuthData($login, $pass)
        );
        if ($is_not_authenticated) {
            header('HTTP/1.1 401 Authorization Required');
            header('WWW-Authenticate: Basic realm="Access denied"');
            exit;
        }
    }

    /**
     * Checks the login information against the database.
     * @param $login
     * @param $password
     * @return bool
     */
    private static function checkAuthData($login, $password): bool
    {
        $pdo = Database::getInstance()->getPDO();

        $sth = $pdo->prepare('
            SELECT login, password FROM admin WHERE login=:login
        ');
        $sth->execute([
            'login' => $login
        ]);
        $row = $sth->fetch();
        if ($row && key_exists('password', $row) && password_verify($password, $row['password'])) {
            return true;
        }
        return false;
    }

    public static function logout()
    {
        header('HTTP/1.1 401 Authorization Required');
    }

}

