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
            <form name="regForm" method="post" action="?c=auth&a=register" onsubmit="return validateForm()">
                <div class="mb-3">
                    <label for="mail" class="form-label">Email</label>
                    <input type="email" class="form-control" name="login" id="mail" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username" oninput="checkUsername()" required>
                    <span id="check-username"></span>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Heslo</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary" id="submitButton">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>
