<?php

namespace App\Controllers;

use App\Auth;
use App\Models\Forum;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use App\Models\News;

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
        $error = $this->request()->getValue('error');
        if(isset($error)) {
            return $this->html(['error' => $error]);
        }
        return $this->html([]);
    }

    public function editpost()
    {
        if(!Auth::isLogged()) {
            $this->redirect('auth','login');
        }

        $postID = $this->request()->getValue('postID');
        $posts = Forum::getAll("id = ?", [$postID]);

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
        if($forumpost->getUser()->getMail()!=$_SESSION['name']) {
            $this->redirect('home','forum', ['error' => "Nie ste vlastníkom postu"]);
        } else {
            if (strlen($title) < 5) {
                $this->redirect('home', 'forum', ['error' => "Krátky názov postu"]);
            }
            else if (strlen($title) > 100) {
                $this->redirect('home', 'forum', ['error' => "Moc dlhý názov postu"]);
            }
            else if (strlen($tags) > 70) {
                $this->redirect('home', 'forum', ['error' => "Veľa tagov na poste "]);
            }
            else if (strlen($text) < 5) {
                $this->redirect('home', 'forum', ['error' => "Krátky popis postu"]);
            }
            else if (strlen($text) > 1000) {
                $this->redirect('home', 'forum', ['error' => "Veľký popis postu"]);
            } else {
                $forumpost->setTitle($title);
                $forumpost->setTags($tags);
                $forumpost->setText($text);
                $forumpost->save();

                $this->redirect('home', 'forum');
            }
        }
    }

    public function deletepost()
    {
        if(!Auth::isLogged()) {
            $this->redirect('auth','login');
        }

        $postID = $this->request()->getValue('postID');
        $forumpost = Forum::getOne($postID);
        $userID = $forumpost->getUser()->getMail();
        if($userID != $_SESSION['name'] && User::isAdmin($_SESSION['name'])!=1) {
            $this->redirect('home','forum', ['error' => 'You are not owner of the post']);
        } else {
            Comment::deleteByPostId($postID);
            $forumpost->delete();

            $this->redirect('home', 'forum');
        }
    }

    public function uploadpost()
    {
        $isOk = true;
        if (!Auth::isLogged()) {
            $this->redirect("home");
            $isOk = false;
        }
        $title = $this->request()->getValue('title');
        $tags = $this->request()->getValue('tags');
        $text = $this->request()->getValue('text');
        if(strlen($title) > 100){
            $this->redirect("home", "createpost", ['error' => 'Moc dlhý názov']);
            $isOk = false;
        }
        if(strlen($title) < 5){
            $this->redirect("home", "createpost", ['error' => 'Krátky názov']);
            $isOk = false;
        }
        if(strlen($tags) > 70){
            $this->redirect("home", "createpost", ['error' => 'Moc dlhé tagy']);
            $isOk = false;
        }
        if(strlen($text) > 1000){
            $this->redirect("home", "createpost", ['error' => 'Moc dlhý text']);
            $isOk = false;
        }
        if(strlen($text) < 5){
            $this->redirect("home", "createpost", ['error' => 'Krátky popis postu']);
            $isOk = false;
        }
        if($isOk == true) {
            $usertable = new User();
            $userID = $usertable->getUserIDByMail();
            $newForum = new Forum();
            $newForum->setTitle($title);
            $newForum->setText($text);
            $newForum->setTags($tags);
            $newForum->setUserId($userID);
            $newForum->save();

            $this->redirect("home", "forum");
        }
    }

    public function forumpost()
    {
        $id = $this->request()->getValue('id');
        $error = $this->request()->getValue('error');
        if(isset($error)) {
            $posts = Forum::getOne($id);
            return $this->html([
                'posts' => $posts,
                'error' => $error
            ]);
        } else {
            $posts = Forum::getOne($id);
            return $this->html(['posts' => $posts]);
        }
    }

    public function contact()
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

    public function forum()
    {
        /*$forum_posts = Forum::getAll();
        $forum_posts = Forum::getPage(2);*/
        $page = $this->request()->getValue('page');
        $numberOfPages = Forum::numberOfPages();
        if($page == null || $page == 0 || $page > $numberOfPages) {
            $page = 1;
        }
        $forum_posts = Forum::getPage($page);
        return $this->html(
            [
                'forum_posts' => $forum_posts,
                'page' => $page,
                'maxPage' => $numberOfPages,
                'error' => $this->request()->getValue('error')
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
        $isOk = true;
        if (!Auth::isLogged()) {
            $this->redirect('home');
            $isOk = false;
        }
        $text =$this->request()->getValue('text');
        $postId = $this->request()->getValue('postid');
        $usertable = new User();
        $user_id = $usertable->getUserIDByMail();
        $idpostu['id'] = $postId;

        if(strlen($text) > 255) {
            $idpostu['error'] = 'Moc dlhý komentár';
            $this->redirect('home', 'forumpost', $idpostu);
            $isOk = false;
        }
        if(strlen($text) < 5) {
            $idpostu['error'] = 'Krátky komentár';
            $this->redirect('home', 'forumpost', $idpostu);
            $isOk = false;
        }
        if($isOk == true) {
            if ($postId) {
                $newComment = new Comment();
                $newComment->setPostId($postId);
                $newComment->setUserId($user_id);
                $newComment->setText($text);
                $newComment->save();
            }
            $this->redirect('home', 'forumpost', $idpostu);
        }
    }

    public function editComment()
    {
        if(!Auth::isLogged()) {
            $this->redirect('auth','login');
        }

        $commentID = $this->request()->getValue('commentID');
        $posts = Forum::getOne(Comment::getOne($commentID)->getPostId());

        return $this->html(
            [
                'posts' => $posts,
                'commentID' => $commentID
            ]);
    }

    public function editCommentsave()
    {
        if(!Auth::isLogged()) {
            $this->redirect('auth','login');
        }
        $isOk = true;
        $id = $this->request()->getValue('commentID');
        $text = $this->request()->getValue('text');
        $editedComment = Comment::getOne($id);
        $user = $editedComment->getUser()->getMail();
        $idpostu['id'] = $editedComment->getPostId();

        if(strlen($text) > 255) {
            $idpostu['error'] = 'Moc dlhý komentár';
            $this->redirect('home', 'forumpost', $idpostu);
            $isOk = false;
        }
        if(strlen($text) < 5) {
            $idpostu['error'] = 'Krátky komentár';
            $this->redirect('home', 'forumpost', $idpostu);
            $isOk = false;
        }
        if($isOk) {
            if ($user == $_SESSION['name']) {
                $editedComment->setText($text);
                $editedComment->save();
                $this->redirect('home', 'forumpost', $idpostu);
            } else {
                $idpostu['error'] = 'Nie ste vlastníkom komentára';
                $this->redirect('home', 'forumpost', $idpostu);
            }
        }
    }

    public function deleteComment() {
        if(!Auth::isLogged()) {
            $this->redirect('auth','login');
        }
        $id = $this->request()->getValue('commentID');
        $chosenComment = Comment::getOne($id);
        $idpostu['id'] = $chosenComment->getPostId();
        $user = $chosenComment->getUser()->getMail();
        if ($user == $_SESSION['name'] || User::isAdmin($_SESSION['name'])==1) {
            $chosenComment->delete();
            $this->redirect('home', 'forumpost', $idpostu);
        } else {
            $this->redirect('home', 'forumpost', $idpostu);
        }
    }

    public function news()
    {
        $news = News::getLatest();
        return $this->html(
            ['news' => $news,
             'error' => $this->request()->getValue('error')]
        );
    }

    public function addNews() {
        $text = $this->request()->getValue('newstext');
        if(strlen($text) < 3) {
            $this->redirect('home', 'news', ['error' => 'Krátky post']);
        } else if (strlen($text) > 255) {
            $this->redirect('home', 'news', ['error' => 'Moc dlhý post']);
        } else {
            $isAdmin = User::isAdmin($_SESSION['name']);
            if($isAdmin == 1) {
                $news = new News();
                $user = new User();
                $news->setText($text);
                $news->setDate(date('Y-m-d-H-i-s'));
                $news->setAdminId($user->getUserIDByMail());
                $news->save();
                $this->redirect('home', 'news');
            } else {
                $this->redirect('home', 'news', ['error' => 'Len admini môžu postovať novinky']);
            }
        }
    }
}