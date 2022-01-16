<?php
$db_handle = mysqli_connect("localhost", "root", "dtb456", "poster");
if(!empty($_POST["keyword"])) {
    $query ="SELECT * FROM users WHERE username like '" . $_POST["keyword"] . "%' ORDER BY username LIMIT 5";
   /* $result = $db_handle->runQuery($query);*/
    $result = mysqli_query($db_handle,$query);
    if(!empty($result)) {
        ?>
        <ul id="user-list">
            <?php
            foreach($result as $user) {
                ?>
                <li onClick="selectUser('<?php echo $user["username"]; ?>');"><?php echo $user["username"]; ?></li>
            <?php } ?>
        </ul>
    <?php } } ?>
