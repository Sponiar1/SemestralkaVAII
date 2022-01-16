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
        $userID = $forumpost->getUser()->getMail();
        if($userID != $_SESSION['name']) {
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
        if(strlen($tags) > 70){
            $this->redirect("home", "createpost", ['error' => 'Moc dlhé tagy']);
            $isOk = false;
        }
        if(strlen($text) > 1000){
            $this->redirect("home", "createpost", ['error' => 'Moc dlhý text']);
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

            $this->redirect("home");
        }
    }

    public function forumpost()
    {
        $id = $this->request()->getValue('id');
        $error = $this->request()->getValue('error');
        if(isset($error)) {
            //$posts = Forum::getAll("id = ?", [$id]);
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

    public function forum()
    {
        /*$forum_posts = Forum::getAll();*/
       /* $forum_posts = Forum::getPage(2);*/
        $page = $this->request()->getValue('page');
        $numberOfPages = Forum::numberOfPages();
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

        $postId = $this->request()->getValue('postid');
        $usertable = new User();
        $user_id = $usertable->getUserIDByMail();
        $idpostu['id'] = $postId;


        if(strlen($this->request()->getValue('text')) > 255) {
            $idpostu['error'] = 'Moc dlhý komentár';
            $this->redirect('home', 'forumpost', $idpostu);
            $isOk = false;
        }
        if($isOk == true) {
            if ($postId) {
                $newComment = new Comment();
                $newComment->setPostId($postId);
                $newComment->setUserId($user_id);
                $newComment->setText($this->request()->getValue('text'));
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
       /* $posts = Forum::getAll("id = ?", [Comment::getOne($commentID)->getPostId()]);*/
        $posts = Forum::getOne(Comment::getOne($commentID)->getPostId());
        //$forumpost = Forum::getOne($postID);

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
        $id = $this->request()->getValue('commentID');
        $text = $this->request()->getValue('text');
        $editedComment = Comment::getOne($id);
        $user = $editedComment->getUser()->getMail();
        if ($user == $_SESSION['name']) {
            $editedComment->setText($text);
            $editedComment->save();

            $this->redirect('home', 'forum');
        } else {
            $this->redirect('home', 'forum');
        }
    }

    public function deleteComment() {
        if(!Auth::isLogged()) {
            $this->redirect('auth','login');
        }
        $id = $this->request()->getValue('commentID');
        $chosenComment = Comment::getOne($id);
        $user = $chosenComment->getUser()->getMail();
        if ($user == $_SESSION['name']) {
            $chosenComment->delete();
            $this->redirect('home', 'forum');
        } else {
            $this->redirect('home', 'forum');
        }
    }

    public function news()
    {
        $news = News::getLatest();
        return $this->html(
            ['news' => $news]
        );
    }

    public function addNews() {
        $text = $this->request()->getValue('newstext');
        $admin = $_SESSION['name'];
        $news = new News();
        $news->setText($text);
        $news->setDate(date('Y-m-d-H-i-s'));
        $news->setAdminId(User::getAdminID());
        $news->save();
        $this->redirect('home', 'news');
    }
}