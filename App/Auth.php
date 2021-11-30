<?php

namespace App;

use App\Models\User;

class Auth
{
    public static function login($login, $password)
    {
        $utable = new User();
        $pokus = $utable->getUser($login, $password);

        if ($pokus == 1)
        {
            $_SESSION["name"] = $login;
            return true;
        } else {
            return false;
        }
        /*
        $filteredUsers = $utable::getAll("mail = ?", [$login]);
        if ($filteredUsers[0]->getPassword() == $password) {
            $_SESSION["name"] = $login;
            return true;
        }
        if ($login == self::LOGIN && $password == self::PASSWORD) {
            $_SESSION["name"] = $login;
            return true;
        } else {
            return false;
        }
        */
    }
    public static function logout()
    {
        unset($_SESSION['name']);
        session_destroy();
    }
    public static function isLogged()
    {
        return isset($_SESSION['name']);
    }

    public static function getName()
    {
        return(Auth::isLogged() ? $_SESSION['name'] : "");
    }

    public static function register($login, $username, $password)
    {
            $userlist = new User();
            $loginNumber = $userlist->getUserByMail($login);
            $usernameNumber = $userlist->getUserByUsername($username);

            if (($loginNumber == 0) && ($usernameNumber == 0)) {
                $userlist->setUsername($username);
                $userlist->setPassword($password);
                $userlist->setMail($login);
                $userlist->save();
                return "OK";
            }
            if ($loginNumber == 1)
                return "Mail already used";
            if ($usernameNumber == 1)
                return "Username already used";
            return false;
    }
}