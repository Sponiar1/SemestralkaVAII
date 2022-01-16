<?php
    $connect = mysqli_connect("localhost", "root", "dtb456", "poster");
if(!empty($_POST["username"])) {
    $query = "SELECT * FROM users WHERE username='" . $_POST["username"] . "'";
    $result = mysqli_query($connect,$query);
    $count = mysqli_num_rows($result);
    if($count>0) {
        echo "<span style='color:red'> Username already exists .</span>";
    }else{
        echo "<span style='color:green'> Username available .</span>";
    }
}
    ?>