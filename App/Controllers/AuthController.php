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

    public function register()
    {
        if (Auth::isLogged()) {
            $this->redirect("home");
        }

        $login = $this->request()->getValue('login');
        $password = $this->request()->getValue('password');
        if (strlen($password) < 6){
            $this->redirect('auth', 'registerForm', ['error' => 'Krátke heslo']);
        }
        if (!preg_match('~[0-9]+~', $password)) {
            $this->redirect('auth', 'registerForm', ['error' => 'Heslo musí obsahovať aspoň jednu číslicu']);
        }
        $username = $this->request()->getValue('username');
        if (strlen($username) < 6){
            $this->redirect('auth', 'registerForm', ['error' => 'Krátke meno']);
        }
        $registered = Auth::register($login, $password, $username);
        sleep(5);
        if($registered == "OK")
        {
            $logged = Auth::login($login, $password);
            if ($logged) {
                $this->redirect('home');
            }
        } else if ($registered == "Mail already used"){
            $this->redirect('auth', 'registerForm', ['error' => 'Mail already used']);
        } else if ($registered == "Username already used"){
            $this->redirect('auth', 'registerForm', ['error' => 'Username already used']);
        } else {
            $this->redirect('auth', 'registerForm', ['error' => 'Error']);
        }
    }
}