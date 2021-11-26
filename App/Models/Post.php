<?php

namespace App\Models;

class Post extends \App\Core\Model
{
    public function __construct (public int $id = 0, public ?string $image = null, public int $likes = 0)
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
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getLikes(): int
    {
        return $this->likes;
    }

    /**
     * @param int $likes
     */
    public function setLikes(int $likes): void
    {
        $this->likes = $likes;
    }
    static public function setDbColumns()
    {
        return ['id', 'image', 'likes'];
    }

    static public function setTableName()
    {
        return "posts";
    }

    public function addLike()
    {
        $this->likes++;
        $this->save();
    }

    public function getComments()
    {
       return Comment::getAll('post_id = ?', [$this->id]);
    }
}