<?php

    $mainServername = "localhost";
    $mainUsername = "root";
    $mainPassword = "";
    $mainDatabase = "ACHS canteen";

    $connection = mysqli_connect($mainServername, $mainUsername, $mainPassword, $mainDatabase);


    if (!$connection) {
        echo "<script>alert('Error Connecting to Database')</script>";
        die();
    }

    
    function getConnection(){
        global $connection;
        return $connection;
    }
    
    function changeDatabaseConnection($dbname){
        global $connection;
        $mainServername = "localhost";
        $mainUsername = "root";
        $mainPassword = "";
        $connection = mysqli_connect($mainServername,$mainUsername, $mainPassword,$dbname);
        if(!$connection){
            echo "<script>alert('Error Connecting to Database')</script>";
            die();
        }
        return $connection;
    }

?>