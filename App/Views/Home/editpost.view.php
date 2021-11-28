<?php /** @var Array $data */ ?>

<div class="posts text-start">
    <?php foreach ($data['forum'] as $post) { ?>
        <form method="post"  action="?c=home&a=editsave&postID=<?= $post->getID() ?>">
            <div class="form-group m-2">
                <input type="text" class="form-control" name="title" value="<?= $post->getTitle() ?>" placeholder="Title">
            </div>
            <div class="form-group m-2">
                <input type="text" class="form-control" name="tags" value="<?= $post->getTags() ?>" placeholder="Tags">
            </div>
            <div class="form-group m-2">
                <label for="exampleFormControlTextarea1">Text</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" name="text" rows="3"><?= $post->getText() ?></textarea>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Odoslať</button>
            </div>
        </form>
    <?php } ?>
</div>

