<?php

namespace App\Controllers;

use App\Auth;
use App\Core\Responses\Response;
use App\Models\User;

class AuthController extends AControllerRedirect
{

    /**
     * @inheritDoc
     */
    public function index()
    {
        // TODO: Implement index() method.
    }

    public function loginForm()
    {
        return $this->html(
            [
                'error' => $this->request()->getValue('error')
            ]
        );
    }

    public function registerForm()
    {
        return $this->html(
            ['error' => $this->request()->getValue('error')]
        );
    }

    public function login()
    {
        $login = $this->request()->getValue('login');
        $password = $this->request()->getValue('password');

        $logged = Auth::login($login, $password);

        if ($logged) {
            $this->redirect('home');
        } else {
            $this->redirect('auth', 'loginForm', ['error' => 'Zlé meno alebo heslo!']);
        }
    }

    public function logout()
    {
        Auth::logout();
        $this->redirect('home');
    }

    public function adminMenu()
    {
        if (!Auth::isLogged()) {
            $this->redirect('auth', 'loginForm', ['error' => 'Zlé meno alebo heslo!']);
        }
        return $this->html(
            []
        );
    }


    public function adminUser()
    {
        $admin = $this->request()->getValue('search-box');
        $userID = User::getUserIDByUsername($admin);
        $user = User::getOne($userID);
        $user->setAdmin(1);
        $user->save();
        $this->redirect('auth', 'adminMenu');
    }

    public function register()
    {
        if (Auth::isLogged()) {
            $this->redirect("home");
        }
        $isOK = true;
        $login = $this->request()->getValue('login');
        $password = $this->request()->getValue('password');
        if (strlen($password) < 6){
            $this->redirect('auth', 'registerForm', ['error' => 'Krátke heslo']);
            $isOK = false;
        }
        if (!preg_match('~[0-9]+~', $password)) {
            $this->redirect('auth', 'registerForm', ['error' => 'Heslo musí obsahovať aspoň jednu číslicu']);
            $isOK = false;
        }
        $username = $this->request()->getValue('username');
        if (strlen($username) < 6){
            $this->redirect('auth', 'registerForm', ['error' => 'Krátke meno']);
            $isOK = false;
        }
        if($isOK == true) {
            $registered = Auth::register($login, $username, $password);
            if ($registered == "OK") {
                $logged = Auth::login($login, $password);
                if ($logged) {
                    $this->redirect('home');
                }
            } else if ($registered == "Mail already used") {
                $this->redirect('auth', 'registerForm', ['error' => 'Mail already used']);
            } else if ($registered == "Username already used") {
                $this->redirect('auth', 'registerForm', ['error' => 'Username already used']);
            } else {
                $this->redirect('auth', 'registerForm', ['error' => 'Error']);
            }
        }
    }
}