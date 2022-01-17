<?php /** @var Array $data */ ?>
<div class="container">
    <h1>NEWS</h1>
    <?php if($data['error'] !="") {?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <?= $data['error'] ?>
        </div>
    <?php } ?>
    <?php if(\App\Auth::isLogged() && \App\Models\User::isAdmin($_SESSION['name']) == 1) { ?>
    <div class="form-group">
        <form name="postnews" method="post"  action="?c=home&a=addNews" onsubmit="return validateNews()">
            <label for="newstext">Add news</label>
            <textarea class="form-control" id="newstext" name="newstext" rows="3"></textarea>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Odoslať</button>
            </div>
        </form>
    </div>
    <?php } ?>
    <?php foreach ($data['news'] as $post) { ?>
        <div>
            <?= $post->getDate() ?>: <?= $post->getText()?>
            <br>
            <?= $post->getUser()->getUsername() ?>
        </div>
        <br>
    <?php } ?>
</div>
