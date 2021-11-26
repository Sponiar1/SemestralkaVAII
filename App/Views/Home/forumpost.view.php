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

        </div>
    <?php } ?>
</div>
