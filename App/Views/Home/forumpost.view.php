<?php /** @var Array $data */ ?>

<div class="posts text-start">
    <?php foreach ($data['forum'] as $post) { ?>
        <div class="post">
            <div class="row">
                <div class="col-9">
                    <a href="?c=home&a=post">
                        <h2>
                            <?= $post->getTitle() ?>
                        </h2>
                    </a>
                </div>
                <div class="col-3 justify-content-end">
                    by <?= $post->getUser()->getUsername() ?>
                </div>
            </div>
            <div class="tags text-info">
                <?= $post->getTags() ?>
                <a href="?c=home&a=post"></a>
            </div>
            <div class="text-white">
                <?= $post->getText() ?>
            </div>
            <?php if (\App\Auth::isLogged()) { ?>
                <div class="text-start mt-2">
                    <form method="post" action="?c=home&a=addComment">
                        <input type="hidden" name="postid" value="<?= $post->getId() ?>">
                        <input type="text" size="19" name="text" placeholder="Vlož svoj komentár">
                        <input type="submit" value="Pošli" name="comment">
                    </form>
                </div>
                <div class="text-start mt-2">
                    <strong>Komentáre:</strong>
                    <?php foreach ($post->getComments() as $comment) { ?>
                        <?= $comment->getText() ?><br>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
