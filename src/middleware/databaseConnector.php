<?php

    function changeDatabaseConnection($dbname){
        global $connection,$mainPassword,$mainServername,$mainUsername;
        $connection = mysqli_connect($mainServername,$mainUsername, $mainPassword,$dbname);
        if(!$connection){
            echo "<script>alert('Error Connecting to Database')</script>";

        }
    }
    $mainServername = "localhost";
    $mainUsername = "root";
    $mainPassword = "";
    $mainDatabase = "ACHS canteen";

    $connection;

    $connection = mysqli_connect($mainServername, $mainUsername, $mainPassword, $mainDatabase);
            
    if (!$connection) {
        echo "<script>alert('Error Connecting to Database')</script>";
        die();
    }

?>