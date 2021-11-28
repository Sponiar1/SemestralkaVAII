<?php /** @var Array $data */ ?>
<div class="container text-center">
    <h1>Forum</h1>
    <a href="?c=home&a=createpost">
    <button type="button" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"></path>
            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"></path>
        </svg>
        Create new post
    </button>
    </a>
    <div class="posts text-start">
        <?php foreach ($data['forum_posts'] as $post) { ?>
        <div class="post">
            <div class="row">
                <div class="col-9">
                    <a href="?c=home&a=forumpost&id=<?= $post->getId()?>">
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
</div>