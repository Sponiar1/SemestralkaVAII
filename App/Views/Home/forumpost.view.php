<?php /** @var Array $data */ ?>

<div class="posts text-start">
    <?php if(array_key_exists('error', $data)) {?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <?= $data['error'] ?>
        </div>
    <?php } ?>
        <div class="post">
            <div class="row">
                <div class="col-9">
                        <h2>
                            <?= $data['posts']->getTitle() ?>
                        </h2>
                </div>
                <div class="col-3 justify-content-end">
                    by <?= $data['posts']->getUser()->getUsername() ?>
                </div>
            </div>
            <div class="tags text-info">
                <?= $data['posts']->getTags() ?>
                <a href="?c=home&a=post"></a>
            </div>
            <div class="text-white">
                <?= $data['posts']->getText() ?>
            </div>
            <?php if (\App\Auth::isLogged()) { ?>
                <div class="text-start mt-2">
                    <form method="post" action="?c=home&a=addComment">
                        <input type="hidden" name="postid" value="<?= $data['posts']->getId() ?>">
                        <input type="text" size="75" name="text" placeholder="Vlož svoj komentár">
                        <input type="submit" value="Pošli" name="comment">
                    </form>
                </div>
            <?php } ?>
                <div class="comments text-start mt-2">
                    <strong>Komentáre:</strong><br>
                    <?php foreach ($data['posts']->getComments() as $comment) { ?>
                        <?php $commentUser=\App\Models\User::getOne($comment->getUserId()) ?>
                        <?= $commentUser->getUsername() ?>:
                        <?= $comment->getText() ?>
                    <?php if (\App\Auth::isLogged() && $comment->getUser()->getMail() == $_SESSION['name']) {?>
                                <a href="?c=home&a=editComment&commentID=<?=$comment->getId() ?>">
                                    <button type="button" class="btn btn-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                                            <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"></path>
                                        </svg>
                                    </button>
                                </a>
                        <?php } ?>
                    <?php if ((\App\Auth::isLogged() && $comment->getUser()->getMail() == $_SESSION['name']) || (\App\Auth::isLogged() && \App\Models\User::isAdmin($_SESSION['name']) == 1)) {?>
                        <a href="?c=home&a=deleteComment&commentID=<?=$comment->getId() ?>">
                                    <button type="button" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete post?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>
                                        </svg>
                                    </button>
                                </a><br>
                    <?php } ?>
                    <?php } ?>
                </div>
        </div>
</div>
