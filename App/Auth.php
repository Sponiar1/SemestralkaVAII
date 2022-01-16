<?php

namespace App;

use App\Models\User;

class Auth
{
    public static function login($login, $password)
    {
        $utable = new User();
        $find = $utable->passwordCheck($login, $password);
        if ($find) {
            $_SESSION["name"] = $login;
        }
        return $find;
        /*
        $utable = new User();
        $pokus = $utable->getUser($login, $password);

        if ($pokus == 1)
        {
            $_SESSION["name"] = $login;
            return true;
        } else {
            return false;
        }*/

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
    public static function isAdmin()
    {
        $userlist = new User();
        $found = $userlist->isAdmin($_SESSION['name']);
        return $found;
    }

    public static function makeAdmin($username)
    {
        $userlist = new User();
        $found = $userlist->getUserByUsername($username);
        return $found;
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
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            if (($loginNumber == 0) && ($usernameNumber == 0)) {
                $userlist->setUsername($username);
                $userlist->setPassword($hashed_password);
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