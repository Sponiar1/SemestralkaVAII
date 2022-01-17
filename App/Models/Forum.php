<?php

namespace App\Models;

use App\Core\DB\Connection;
use PDO;

class Forum extends \App\Core\Model
{

    public function __construct(public int $id = 0,
                                public int $user_id = 0,
                                public ?string $tags = null,
                                public ?string $title = null,
                                public ?string $text = null)
    {
    }

    static public function setDbColumns()
    {
        return ['id', 'user_id', 'tags', 'title', 'text'];
    }

    static public function setTableName()
    {
        return 'forum';
    }

    static public function numberOfPages() {
        self::connect();
        $pr = Connection::connect()->prepare('SELECT * FROM forum');
        $pr->execute([]);
        $count = $pr->rowCount();
        $maxPage = ceil ($count / 3);
        return $maxPage;
    }

    public function getUser()
    {
        return User::getOne($this->getUserId());
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
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string|null
     */
    public function getTags(): ?string
    {
        return $this->tags;
    }

    /**
     * @param string|null $tags
     */
    public function setTags(?string $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
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

    public function getComments()
    {
        return Comment::getAll('post_id = ?', [$this->id]);
    }

}