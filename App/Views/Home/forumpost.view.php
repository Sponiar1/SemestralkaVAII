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
                        <input type="text" size="19" name="text" placeholder="Vlož svoj komentár">
                        <input type="submit" value="Pošli" name="comment">
                    </form>
                </div>
                <div class="comments text-start mt-2">
                    <strong>Komentáre:</strong><br>
                    <?php foreach ($data['posts']->getComments() as $comment) { ?>
                        <?php $commentUser=\App\Models\User::getOne($comment->getUserId()) ?>
                        <?= $commentUser->getUsername() ?>:
                        <?= $comment->getText() ?><br>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
</div>
