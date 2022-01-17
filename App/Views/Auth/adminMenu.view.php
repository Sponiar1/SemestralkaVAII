<?php /** @var Array $data */ ?>
<br>
<?php if(array_key_exists('error', $data)) {?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <?= $data['error'] ?>
    </div>
<?php } ?>
<div class="frmSearch text-center">
    <form method="post" action="?c=auth&a=adminUser">
    <input type="text" id="search-box" name="search-box" placeholder="Find User" />

    <div id="suggesstion-box"></div>
    <div></div>
    <br>
    <button type="submit" class="btn btn-primary" id="submitButton">Make Admin</button>
    </form>
</div>
<br>
