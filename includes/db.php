<?php
    
    $db['db_host'] = "localhost";
    $db['db_user'] = "root";
    $db['db_password'] = "";
    $db['db_name'] = "cms";
    
    //loop to convert variables into constants
    foreach($db as $key => $value){
        define(strtoupper($key), $value);
    }

    
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if(!$connection){
        die("Database Connection Failed!");
    }
?>