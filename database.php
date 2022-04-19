<?php
    $hostname = "172.20.160.2:3360";
    $database = "mydb";
    $user = "root";
    $password = "my-secret-pw";
    $mysqli = new mysqli($hostname, $user, $password, $database);

    if($mysqli -> connect_error){
        echo "Errore Database".$mysqli-> connect_error;
    }
?>