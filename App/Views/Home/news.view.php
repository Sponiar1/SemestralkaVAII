<?php /** @var Array $data */ ?>
<div class="container">
    <h1>NEWS</h1>
    <?php if(\App\Auth::isLogged() && \App\Models\User::isAdmin($_SESSION['name']) == 1) { ?>
    <div class="form-group">
        <form method="post"  action="?c=home&a=addNews">
            <label for="exampleFormControlTextarea1">Add news</label>
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
        </div>
        <br>
    <?php } ?>
</div>
