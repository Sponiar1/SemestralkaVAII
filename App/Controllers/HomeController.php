<?php

namespace App\Controllers;

use App\Auth;
use App\Models\Forum;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;

/**
 * Class HomeController
 * Example of simple controller
 * @package App\Controllers
 */
class HomeController extends AControllerRedirect
{

    public function index()
    {
        $posts = Post::getAll();

        return $this->html(
            [
                'posts' => $posts
            ]);
    }

    public function addLike()
    {
        $postId = $this->request()->getValue('postid');
        if ($postId > 0) {
            $post = Post::getOne($postId);
            $post->addLike();
        }
        $this->redirect('home');
    }

    public function upload()
    {
        if (!Auth::isLogged()) {
            $this->redirect("home");
        }
        if (isset($_FILES['file'])) {
            if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) {
                $name = date('Y-m-d-H-i-s_') . $_FILES['file']['name'];
                move_uploaded_file($_FILES['file']['tmp_name'], \App\Config\Configuration::UPLOAD_DIR . "$name");
                $newPost = new Post();
                $newPost->setImage($name);
                $newPost->save();
            }
        }
        $this->redirect("home");
    }

    public function post()
    {
        if(!Auth::isLogged()) {
            $this->redirect('home');
        }
        return $this->html();
    }

    public function createpost()
    {
        if(!Auth::isLogged()) {
            $this->redirect('auth','login');
        }
        return $this->html();
    }

    public function editpost()
    {
        if(!Auth::isLogged()) {
            $this->redirect('auth','login');
        }

        $postID = $this->request()->getValue('postID');
        $posts = Forum::getAll("id = ?", [$postID]);
        //$forumpost = Forum::getOne($postID);

        return $this->html(
            [
                'forum' => $posts
            ]);
    }

    public function editsave()
    {
        if(!Auth::isLogged()) {
            $this->redirect('auth','login');
        }
        $id = $this->request()->getValue('postID');
        $title = $this->request()->getValue('title');
        $tags = $this->request()->getValue('tags');
        $text = $this->request()->getValue('text');
        $forumpost = Forum::getOne($id);
        $forumpost->setTitle($title);
        $forumpost->setTags($tags);
        $forumpost->setText($text);
        $forumpost->save();

        $this->redirect('home','forum');
    }

    public function deletepost()
    {
        if(!Auth::isLogged()) {
            $this->redirect('auth','login');
        }

        $postID = $this->request()->getValue('postID');
        $forumpost = Forum::getOne($postID);
        $forumpost->delete();

        $this->redirect('home','forum');
    }

    public function uploadpost()
    {
        if (!Auth::isLogged()) {
            $this->redirect("home");
        }
        $title = $this->request()->getValue('title');
        $tags = $this->request()->getValue('tags');
        $text = $this->request()->getValue('text');
        $usertable = new User();
        $userID = $usertable->getUserIDByMail();
                $newForum = new Forum();
                $newForum->setTitle($title);
                $newForum->setText($text);
                $newForum->setTags($tags);
                $newForum->setUserId($userID);
                $newForum->save();

        $this->redirect("home");
    }

    public function forumpost()
    {
        $id = $this->request()->getValue('id');
        //$posts = Forum::getAll("id = ?", [$id]);
        $posts = Forum::getOne($id);
        return $this->html($posts);
    }

    public function contact()
    {
        return $this->html(
            []
        );
    }

    public function faq()
    {
        return $this->html(
            []
        );
    }

    public function about()
    {
        return $this->html(
            []
        );
    }

    public function news()
    {
        return $this->html(
            []
        );
    }

    public function forum()
    {
        $forum_posts = Forum::getAll();

        return $this->html(
            [
                'forum_posts' => $forum_posts
            ]);
    }

    public function profile()
    {
        $usertable = new User();
        $profil = User::getOne($usertable->getUserIDByMail());
        return $this->html($profil);
    }

    public function addComment()
    {
        if (!Auth::isLogged()) {
            $this->redirect('home');
        }

        $postId = $this->request()->getValue('postid');
        $usertable = new User();
        $user_id = $usertable->getUserIDByMail();
        $idpostu['id'] = $postId;
        if($postId) {
            $newComment = new Comment();
            $newComment->setPostId($postId);
            $newComment->setUserId($user_id);
            $newComment->setText($this->request()->getValue('text'));
            $newComment->save();
        }
        $this->redirect('home', 'forumpost', $idpostu);
    }
}