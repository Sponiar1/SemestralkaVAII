<?php

namespace App\Models;
use App\Core\DB\Connection;
class User extends \App\Core\Model
{
    public function __construct(public int $id = 0,
                                public ?string $username = null,
                                public ?string $password = null,
                                public ?string $mail = null,
                                public ?string $profile_pic = null,
                                public int $admin = 0)
    {

    }


    public function getUser($login, $password)
    {
        self::connect();
        $pr = Connection::connect()->prepare('SELECT * FROM users WHERE mail = ? and password = ?');
        $pr->execute([$login, $password]);
        /*$users = $pr->fetchAll();*/
        $count = $pr->rowCount();
        return $count;
    }

    public function getUserByMail($login)
    {
        self::connect();
        $pr = Connection::connect()->prepare('SELECT * FROM users WHERE mail = ?');
        $pr->execute([$login]);
        $count = $pr->rowCount();
        return $count;
    }

    public function getUserByUsername($username)
    {
        self::connect();
        $pr = Connection::connect()->prepare('SELECT * FROM users WHERE username = ?');
        $pr->execute([$username]);
        $count = $pr->rowCount();
        return $count;
    }

    public function getUserIDByMail()
    {
        self::connect();
        $pr = Connection::connect()->prepare('SELECT * FROM users WHERE mail = ?');
        $pr->execute([$_SESSION['name']]);
        $id = $pr->fetch();
        $foundid = $id['id'];
        return $foundid;
    }

    public function getUserIDByUsername($username)
    {
        self::connect();
        $pr = Connection::connect()->prepare('SELECT * FROM users WHERE username = ?');
        $pr->execute([$username]);
        $id = $pr->fetch();
        $foundid = $id['id'];
        return $foundid;
    }

    public function passwordCheck($mail, $password)
    {
        self::connect();
        $pr = Connection::connect()->prepare('SELECT * FROM users WHERE mail = ?');
        $pr->execute([$mail]);
        $id = $pr->fetch();
        $found = $id['password'];
        $ok = password_verify($password, $found);
        return $ok;
    }

    public static function isAdmin($mail)
    {
        self::connect();
        $pr = Connection::connect()->prepare('SELECT * FROM users WHERE mail = ? and admin = ?');
        $pr->execute([$mail, 1]);
        $count = $pr->rowCount();
        return $count;
    }

    public static function isLoggedAdmin()
    {
        self::connect();
        $pr = Connection::connect()->prepare('SELECT * FROM users WHERE mail = ? and admin = ?');
        $pr->execute([$_SESSION['name']],1);
        $count = $pr->rowCount();
        return $count;
    }

    public static function getAdminID()
    {
        self::connect();
        $pr = Connection::connect()->prepare('SELECT * FROM users WHERE mail = ?');
        $pr->execute([$_SESSION['name']]);
        $id = $pr->fetch();
        $foundid = $id['id'];
        return $foundid;
    }

    public static function makeAdmin($mail)
    {
        self::connect();
        $pr = Connection::connect()->prepare('SELECT * FROM users WHERE mail = ? and admin = ?');
        $pr->execute([$mail, 1]);
        $count = $pr->rowCount();
        return $count;
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getMail(): ?string
    {
        return $this->mail;
    }

    /**
     * @param string|null $mail
     */
    public function setMail(?string $mail): void
    {
        $this->mail = $mail;
    }

    /**
     * @return string|null
     */
    public function getProfilePic(): ?string
    {
        return $this->profile_pic;
    }

    /**
     * @param string|null $profile_pic
     */
    public function setProfilePic(?string $profile_pic): void
    {
        $this->profile_pic = $profile_pic;
    }

    static public function setDbColumns()
    {
        return ['id', 'username', 'password', 'mail', 'admin'];
    }

    static public function setTableName()
    {
        return 'users';
    }

    /**
     * @return int
     */
    public function getAdmin(): int
    {
        return $this->admin;
    }

    /**
     * @param int $admin
     */
    public function setAdmin(int $admin): void
    {
        $this->admin = $admin;
    }
}