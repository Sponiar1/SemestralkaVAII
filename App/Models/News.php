<?php

namespace App\Models;
use App\Core\DB\Connection;

class News extends \App\Core\Model
{
    public function __construct(public int $id = 0,
                                public int $admin_id = 0,
                                public ?string $text = null,
                                public ?string $date = null)
    {

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
     * @return int
     */
    public function getAdminId(): int
    {
        return $this->admin_id;
    }

    /**
     * @param int $admin_id
     */
    public function setAdminId(int $admin_id): void
    {
        $this->admin_id = $admin_id;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     */
    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return string|null
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @param string|null $date
     */
    public function setDate(?string $date): void
    {
        $this->date = $date;
    }

    public function getUser()
    {
        return User::getOne($this->getAdminId());
    }

    static public function setDbColumns()
    {
        return ['id', 'admin_id', 'text', 'date'];
    }

    static public function setTableName()
    {
        return 'news';
    }
}