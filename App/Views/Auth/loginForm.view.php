<?php /** @var Array $data */?>
<div class="container">
    <div class="row">
        <div class="col-sm-5 offset-sm-4">
            <?php if($data['error'] !="") {?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <?= $data['error'] ?>
            </div>
            <?php } ?>
            <form method="post" action="?c=auth&a=login">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email</label>
                    <input type="email" class="form-control" name="login" id="exampleFormControlInput1" required>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput2" class="form-label">Heslo</label>
                    <input type="password" class="form-control" name="password" id="exampleFormControlInput2" required>
                </div>
                <div class=" row mb-3 row justify-content-between">
                    <div class = "col-3">
                        <button type="submit" class="btn btn-primary">Prihlásiť</button>
                    </div>
                    <div class = "reglink col-3">
                        <a href="?c=auth&a=registerForm">Register</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
