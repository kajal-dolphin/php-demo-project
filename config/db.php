<?php

    if (!isset($_SESSION)) {
        session_start();
    }

    $servername = "localhost";
    $username = "root";
    $password = "Admin@123";
    $dbname = "php_demo_project";

    $connection = mysqli_connect($servername, $username, $password, $dbname);
?>