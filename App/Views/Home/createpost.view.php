<?php ?>
<div class="container">
    <h1> NEW POST </h1>
        <form method="post"  action="?c=home&a=uploadpost">
            <div class="form-group m-2">
                <input type="text" class="form-control" name="title" placeholder="Title" required>
            </div>
            <div class="form-group m-2">
                <input type="text" class="form-control" name="tags" placeholder="Tags">
            </div>
            <div class="form-group m-2">
                <label for="exampleFormControlTextarea1">Text</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" name="text" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Odoslať</button>
            </div>
        </form>
</div>