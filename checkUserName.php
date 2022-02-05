<?php
    include('connDB.php');
    $UserName = $_POST['username'];
    $sql = "SELECT username FROM users WHERE username = '$UserName'";

    $CheckUserName = $conn->query($sql);
    $Result = $CheckUserName->fetch(PDO::FETCH_ASSOC);  
    if(isset($Result['username'])){
        echo "1";
    }else{
        echo "2";
    }


?>