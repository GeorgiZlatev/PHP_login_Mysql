<?php 
    $dbHost = "localhost";
    $dbUser = "user";
    $dbPass = "pass";
    $dbName = "db_name";

    $conn = mysqli_connect ($dbHost, $dbUser, $dbPass, $dbName);

if (!$conn){
        die("Database connection fail!");
}

 ?>