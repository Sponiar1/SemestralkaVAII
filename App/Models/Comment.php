<?php

namespace App\Models;

use App\Core\Model;
use App\Core\DB\Connection;

class Comment extends Model
{

    public function __construct(public int $id = 0,
                                public ?string $text = null,
                                public int $post_id = 0,
                                public int $user_id = 0)
    {

    }

    static public function setDbColumns()
    {
        return ['id', 'post_id', 'text', 'user_id'];
    }

    public static function deleteByPostId($post_id)
    {
        self::connect();
        $pr = Connection::connect()->prepare('DELETE FROM comments WHERE post_id = ?');
        $pr->execute([$post_id]);
    }

    public function getUser()
    {
        return User::getOne($this->getUserId());
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

    static public function setTableName()
    {
        return "comments";
    }

    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->post_id;
    }

    /**
     * @param int $post_id
     */
    public function setPostId(int $post_id): void
    {
        $this->post_id = $post_id;
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
}